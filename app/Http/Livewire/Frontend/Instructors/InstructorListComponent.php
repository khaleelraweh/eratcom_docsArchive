<?php

namespace App\Http\Livewire\Frontend\Instructors;

use App\Models\Specialization;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class InstructorListComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;

    // ============ filter choice ==========//
    public $selectedSpecializations = [];
    public $searchQuery = '';
    public $selectedNames = [];
    public $selectedRatings = [];
    protected $queryString = ['selectedSpecializations', 'selectedNames', 'searchQuery', 'selectedRatings'];

    public function resetFilters()
    {
        $this->selectedSpecializations = [];
        $this->searchQuery = '';
        $this->selectedNames = [];
        $this->selectedRatings = [];
    }

    public function render()
    {
        // Query for filter menu 
        $specializations_menu = Specialization::withCount(['users' => function ($query) {
            $query->whereHasRoles('instructor')->has('courses');
        }])->get();

        // Get the IDs of selected specializations
        $selectedSpecializationIds = Specialization::whereIn('slug->' . app()->getLocale(), $this->selectedSpecializations)->pluck('id')->toArray();

        $instructors_menu = User::whereHasRoles('instructor')->hasCourses()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $this->searchQuery . '%');
                });
            })
            ->get()
            ->groupBy(function ($user) {
                return $user->first_name . ' ' . $user->last_name;
            })
            ->map(function ($group) {
                return $group->count();
            });

        // Get instructors
        $instructors = User::whereHasRoles('instructor')
            ->when($this->selectedSpecializations, function ($query) use ($selectedSpecializationIds) {
                return $query->whereHas('specializations', function ($subQuery) use ($selectedSpecializationIds) {
                    $subQuery->whereIn('specialization_id', $selectedSpecializationIds);
                });
            })
            ->when($this->selectedNames, function ($query) {
                return $query->where(function ($subQuery) {
                    foreach ($this->selectedNames as $fullName) {
                        $subQuery->orWhereRaw('CONCAT(first_name, " ", last_name) LIKE ?', ["%{$fullName}%"]);
                    }
                });
            })

            ->when($this->selectedRatings, function ($query) {
                // Filter instructors based on the average rating of their courses
                $query->whereHas('courses.reviews', function ($reviewQuery) {
                    $reviewQuery->whereIn('rating', $this->selectedRatings);
                });
            })
            ->has('courses')
            ->active()
            ->get();

        return view(
            'livewire.frontend.instructors.instructor-list-component',
            [
                'specializations_menu'  =>  $specializations_menu,
                'instructors_menu'       =>  $instructors_menu,
                'instructors' => $instructors,
            ]
        );
    }

    public function submitSearch()
    {
    }
}
