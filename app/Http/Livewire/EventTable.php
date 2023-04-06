<?php

namespace App\Http\Livewire;

use App\Models\Events\Event;
use App\Models\Groups\Group;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class EventTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public Group $group; // TODO protect against user tampering
    public bool $upcoming = true;
    public array $entries_per_page = [10, 10];
    public array $cols; // Format col_name => [label, type, display, sort_direction, sort_idx, table_idx]
    public array $col_opts;
    public array $filters = [];
    public string $query = '';
    public array $new_event_data = ['title' => null, 'start' => null, 'end' => null, 'description' => null];

    public function mount()
    {
        $this->cols = array_combine($this->cols, array_map(fn($i) => ['sort_direction' => null, 'sort_idx' => $i, 'table_idx' => $i],
                                                           array_keys($this->cols)));
        $this->col_opts = [
            'title' =>  ['label' => 'Title',  'type' => 'text',     'display' => 'val'],
            'start' =>  ['label' => 'Start',  'type' => 'datetime', 'display' => 'datetime'],
            'end' =>    ['label' => 'End',    'type' => 'datetime', 'display' => 'datetime'],
            'status' => ['label' => 'Status', 'type' => 'status',   'display' => 'status']
        ];

        $this->new_event_data['start'] = Carbon::now()->addHours(24)->ceilHour()->format('Y-m-d\TH:i');
        $this->new_event_data['end'] = Carbon::now()->addHours(26)->ceilHour()->format('Y-m-d\TH:i');
    }

    public function switchView()
    {
        $this->upcoming = !$this->upcoming;
    }

    public function newEvent()
    {
        $new_event = Event::create(['title' => $this->new_event_data['title'],
                                    'start' => $this->new_event_data['start'],
                                    'end' => $this->new_event_data['end'],
                                    'description' => $this->new_event_data['description'] ?? '',
                                    'body' => '',
                                    'group' => $this->group->id]);
        return redirect()->to('/event/'.$new_event->slug.'/edit');
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
        // TODO inefficient, as both lists are re-calculated on each change, even though probably only one changed. May be improved.s
        $event_queries = [null, null];
        foreach ($event_queries as $idx => $val) {
            $event_queries[$idx] = Event::where([['group', $this->group->id]])
                                        ->whereRaw('`start` ' . ($idx == 0 ? '<' : '>=') . ' NOW()');
        }

        foreach ($event_queries as $idx => $val) {
            foreach ($this->filters as $col => $filters) {
                $event_queries[$idx]->where($col, $filters);
            }
        }

        foreach ($event_queries as $idx => $val) {
            if ($this->query != '') {
                $event_queries[$idx]->where('title', 'LIKE', "%$this->query%");
            }
        }

        // Sort columns by table sorting priority
        uasort($this->cols, fn($x, $y) => $x['sort_idx'] < $y['sort_idx']);

        foreach ($event_queries as $idx => $val) {
            foreach ($this->cols as $col => $attrs) {
                // Check first if data should be sorted by this column
                if ($attrs['sort_direction'] == null)
                    continue;

                $event_queries[$idx]->orderBy($col, $attrs['sort_direction']);
            }
        }

        // Revert columns to original (display) sorting
        uasort($this->cols, fn($x, $y) => $x['table_idx'] > $y['table_idx']);

        return view('livewire.event-table', [
            'events' => [$event_queries[0]->paginate($this->entries_per_page[0]),
                         $event_queries[1]->paginate($this->entries_per_page[1])]
        ]);
    }
}
