<?php

namespace App\Livewire;

use App\Models\Groups\Group;
use App\Models\Groups\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public int $entries_per_page = 10;
    public bool $disable_entries_per_page = false;

    public bool $add_view_button = true;
    public bool $add_add_button = false;
    public bool $add_remove_button = false;

    public array $cols; // Format col_name => [label, type, display, sortable, sort_direction, sort_idx, table_idx]
    public array $col_opts;
    public array $filters = [];
    public string $query = '';
    #[Locked]
    public Group $group;

    protected $listeners = ['refreshUserTable' => 'render'];

    public function mount()
    {
        $this->cols = array_combine($this->cols, array_map(fn($i) => ['sort_direction' => null, 'sort_idx' => $i, 'table_idx' => $i],
                                                           array_keys($this->cols)));
        $this->col_opts = [
            'name' =>              ['label' => 'Name',              'sortable' => true,  'type' => 'text',     'display' => 'full_name'],
            'first_name' =>        ['label' => 'First name',        'sortable' => true,  'type' => 'text',     'display' => 'val'],
            'last_name' =>         ['label' => 'Last name',         'sortable' => true,  'type' => 'text',     'display' => 'val'],
            'email' =>             ['label' => 'Email address',     'sortable' => true,  'type' => 'email',    'display' => 'val'],
            'email_verified_at' => ['label' => 'Email verified',    'sortable' => true,  'type' => 'datetime', 'display' => 'check'],
            'created_at' =>        ['label' => 'Registered',        'sortable' => true,  'type' => 'datetime', 'display' => 'date'],
            'groups' =>            ['label' => 'Groups',            'sortable' => false,  'type' => null,       'display' => 'groups'],
            'roles' =>             ['label' => 'Roles',             'sortable' => false,  'type' => null,       'display' => 'roles'],
            'user_verified_at' =>  ['label' => 'Verified',          'sortable' => true,  'type' => 'datetime', 'display' => 'verify'],
        ];
        foreach (setting('account.custom_fields') as $custom_col) {
            // TODO determine appropriate 'display'-type?
            $this->col_opts[$custom_col->name] = ['label' => $custom_col->label, 'type' => $custom_col->type, 'display' => 'val'];
        }
    }

    public function verifyUser($user_id)
    {
        if (!Auth::user()->can('user.manage'))
            return;

        $user = User::find($user_id);
        if (!$user || $user->user_verified_at)
            return;
        
        $user->update(['user_verified_at' => Carbon::now()]);
    }

    public function addUserToGroup($user_id)
    {
        if (!Auth::user()->can('user.assign') || !isset($this->group))
            return;

        $user = User::find($user_id);
        if (!$user)
            return;

        $user->assignRole($this->group->name.'.');
        $this->dispatch('refreshUserTable');
    }

    public function removeUserFromGroup($user_id)
    {
        if (!Auth::user()->can('user.assign') || !isset($this->group))
            return;

        $user = User::find($user_id);
        if (!$user)
            return;
        
        foreach (Role::where('name', 'LIKE', $this->group->name.'.%')->get() as $role)
            $user->removeRole($role);
        $this->dispatch('refreshUserTable');
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
                case 'notgroup':
                    $user_query->whereNotExists(function (Builder $query) use ($filters) {
                        $query->from('model_has_roles')
                              ->join('roles', 'roles.id', 'model_has_roles.role_id')
                              ->where('roles.name', $filters.'.')
                              ->whereColumn('model_has_roles.model_id', 'users.id');
                    });
                    break;
                default:
                    $user_query->where($col, $filters);
            }
        }
        //dd($user_query->toSql(), $user_query->get(), $this->filters);
        if ($this->query != '')
            $user_query->where(function ($query) {
                $query->whereRaw('CONCAT(first_name, \' \', last_name) LIKE ?', ["%$this->query%"])
                      ->orWhere('email', 'LIKE', "%$this->query%");
            });

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
                case 'full_name':
                    $user_query->orderBy('last_name', $attrs['sort_direction']);
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
