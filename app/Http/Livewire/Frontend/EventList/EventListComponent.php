<?php

namespace App\Http\Livewire\Frontend\EventList;

use App\Models\Course;
use App\Models\CourseCategory;
use Livewire\Component;

class EventListComponent extends Component
{

    public $amount = 6;
    public $events;
    public $showMoreBtn = false;
    public $showLessBtn = false;

    // filtering 
    public $categoryInputs;
    public $sortingBy;
    public $searchQuery = '';
    protected $queryString = ['categoryInputs', 'sortingBy', 'searchQuery'];


    public function render()
    {
        // Fetch categories menu
        $categories_menu = CourseCategory::whereHas('courses', function ($query) {
            $query->Event();
        })->hasCourses()->withCount('courses')->get();

        // Build query to fetch events
        $query = Course::with('photos', 'topics', 'requirements')->Event();


        // Apply category filter if selected
        if ($this->categoryInputs !== null) {
            // Check if "Choose Categories" option is selected
            if ($this->categoryInputs == '') {
                // Don't apply category filter
            } else {
                $query->where('course_category_id', $this->categoryInputs);
            }
        }


        // Apply search query filter
        if ($this->searchQuery) {
            $query->where('title', 'LIKE', '%' . $this->searchQuery . '%');
        }

        // Apply sorting
        switch ($this->sortingBy) {
            case 'new-events':
                $query->orderBy('created_at', 'desc');
                break;
            case 'new-old':
                $query->orderBy('created_at', 'asc');
                break;
            case 'old-new':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
                break;
        }

        // Fetch events based on query
        $this->events = $query->get();

        // Determine button visibility based on event count
        $totalEventsCount = count($this->events);
        $this->showMoreBtn = $totalEventsCount > $this->amount;
        $this->showLessBtn = $totalEventsCount > 6;

        return view('livewire.frontend.event-list.event-list-component', [
            'events' => $this->events,
            'categories_menu' => $categories_menu
        ]);
    }


    public function load_more()
    {
        $this->amount += 3;
    }

    public function load_less()
    {
        $this->amount = 6;
    }
}
