<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public int $entries_per_page;
    public array $cols; // Format col_name => [label, type, display, sort_direction, sort_idx, table_idx]
    public array $col_opts;

    public string $query;

    public function mount()
    {
        $this->entries_per_page = 10;
        $this->cols = [
            'first_name' =>        ['sort_direction' => null, 'sort_idx' => 0, 'table_idx' => 0],
            'last_name' =>         ['sort_direction' => null, 'sort_idx' => 1, 'table_idx' => 1],
            'email' =>             ['sort_direction' => null, 'sort_idx' => 2, 'table_idx' => 2],
            'email_verified_at' => ['sort_direction' => null, 'sort_idx' => 3, 'table_idx' => 3],
            'created_at' =>        ['sort_direction' => null, 'sort_idx' => 4, 'table_idx' => 4],
            'user_verified_at' =>  ['sort_direction' => null, 'sort_idx' => 5, 'table_idx' => 5],
        ];
        $this->col_opts = [
            'first_name' =>        ['label' => 'First name',     'type' => 'text',     'display' => 'val'],
            'last_name' =>         ['label' => 'Last name',      'type' => 'text',     'display' => 'val'],
            'email' =>             ['label' => 'Email address',  'type' => 'email',    'display' => 'val'],
            'email_verified_at' => ['label' => 'Email verified', 'type' => 'datetime', 'display' => 'check'],
            'created_at' =>        ['label' => 'Registered',     'type' => 'datetime', 'display' => 'val'],
            'user_verified_at' =>  ['label' => 'Verified',       'type' => 'datetime', 'display' => 'verify'],
        
        ];
        foreach (setting('account.custom_fields') as $custom_col) {
            // TODO determine appropriate 'display'-type?
            $this->col_opts[$custom_col->name] = ['label' => $custom_col->label, 'type' => $custom_col->type, 'display' => 'val'];
        }
        $this->query = '';
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
        if ($this->query != '')
            $user_query = User::whereRaw('CONCAT(first_name, \' \', last_name) LIKE ?', ["%$this->query%"])
                              ->orWhere('email', 'LIKE', "%$this->query%");
        else 
            $user_query = User::where([]);

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
