<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public int $entries_per_page = 10;
    public array $cols; // Format col_name => [label, type, display, sort_direction, sort_idx, table_idx]
    public array $col_opts;
    public array $filters = [];
    public string $query = '';

    public function mount()
    {
        $this->cols = array_combine($this->cols, array_map(fn($i) => ['sort_direction' => null, 'sort_idx' => $i, 'table_idx' => $i],
                                                           array_keys($this->cols)));
        $this->col_opts = [
            'first_name' =>        ['label' => 'First name',     'type' => 'text',     'display' => 'val'],
            'last_name' =>         ['label' => 'Last name',      'type' => 'text',     'display' => 'val'],
            'email' =>             ['label' => 'Email address',  'type' => 'email',    'display' => 'val'],
            'email_verified_at' => ['label' => 'Email verified', 'type' => 'datetime', 'display' => 'check'],
            'created_at' =>        ['label' => 'Registered',     'type' => 'datetime', 'display' => 'date'],
            'groups' =>            ['label' => 'Groups',         'type' => null,       'display' => 'groups'],
            'roles' =>             ['label' => 'Roles',          'type' => null,       'display' => 'roles'],
            'user_verified_at' =>  ['label' => 'Verified',       'type' => 'datetime', 'display' => 'verify']
        ];
        foreach (setting('account.custom_fields') as $custom_col) {
            // TODO determine appropriate 'display'-type?
            $this->col_opts[$custom_col->name] = ['label' => $custom_col->label, 'type' => $custom_col->type, 'display' => 'val'];
        }
    }

    public function sortTable($col)
    {
        if (!array_key_exists($col, $this->cols))
            return;

        $switch_array = ['' => 'asc', 'asc' => 'desc', 'desc' => null];
        $this->cols[$col]['sort_direction'] = $switch_array[$this->cols[$col]['sort_direction']];
        $this->cols[$col]['sort_idx'] = max(array_column($this->cols, 'sort_idx')) + 1;
    }

    public function render()
    {
        $user_query = User::where([]);
        foreach ($this->filters as $col => $filters) {
            switch($col) {
                case 'group':
                    $user_query->role($filters.'.');
                    break;
                default:
                    $user_query->where($col, $filters);
            }
        }
        if ($this->query != '')
            $user_query = $user_query->whereRaw('CONCAT(first_name, \' \', last_name) LIKE ?', ["%$this->query%"])
                                     ->orWhere('email', 'LIKE', "%$this->query%");

        // Sort columns by table sorting priority
        uasort($this->cols, fn($x, $y) => $x['sort_idx'] < $y['sort_idx']);

        foreach ($this->cols as $col => $attrs) {
            // Check first if data should be sorted by this column
            if ($attrs['sort_direction'] == null)
                continue;

            switch ($this->col_opts[$col]['display']) {
                case 'check':
                case 'verify':
                    // NOTE: Cannot bind column names.
                    // NOTE: sort_direction should NEVER be user-assignable!!!
                    // TODO: Is this solution safe?
                    $col = preg_replace('/[^a-zA-Z0-9_-]/', '', $col);
                    $user_query->orderByRaw('CASE WHEN `' . $col . '` IS NULL THEN 1 ELSE 0 END ' . $attrs['sort_direction']);
                    break;
                case 'groups':
                    break;
                default:
                    $user_query->orderBy($col, $attrs['sort_direction']);
            }
        }

        // Revert columns to original (display) sorting
        uasort($this->cols, fn($x, $y) => $x['table_idx'] > $y['table_idx']);

        return view('livewire.user-table', [
            'users' => $user_query->paginate($this->entries_per_page)
        ]);
    }
}
