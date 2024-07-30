<?php

namespace App\Http\Livewire\Frontend\Courses;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CourseListComponent extends Component
{


    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;

    public $slug;
    public $sortingBy = "default";

    //To filter by categories choosen 
    public $categoryInputs = [];

    // To Filter by level choosen 
    public $courseLevels = [];

    // To filter by price type 
    public $priceInput;

    public $searchQuery = '';
    public $selectedNames = [];
    public $selectedRatings = [];

    protected $queryString = ['categoryInputs', 'courseLevels', 'priceInput', 'searchQuery', 'selectedNames', 'selectedRatings'];

    public function resetFilters()
    {
        $this->sortingBy = "default";
        $this->priceInput = '';
        $this->courseLevels = [];
        $this->categoryInputs = [];

        $this->searchQuery = '';
        $this->selectedNames = [];
        $this->selectedRatings = [];
    }

    public function render()
    {
        // $instructors_menu = User::whereHasRoles('instructor')->hasCourses()
        //     ->orderBy('first_name')
        //     ->orderBy('last_name')
        //     ->when($this->searchQuery, function ($query) {
        //         $query->where(function ($subQuery) {
        //             $subQuery->where('first_name', 'LIKE', '%' . $this->searchQuery . '%')
        //                 ->orWhere('last_name', 'LIKE', '%' . $this->searchQuery . '%');
        //         });
        //     })
        //     ->withCount('courses') // Load the count of associated courses for each instructor
        //     ->get()
        //     ->groupBy(function ($user) {
        //         return $user->first_name . ' ' . $user->last_name;
        //     })
        //     ->map(function ($group) {
        //         // Calculate the count of instructors in each group
        //         $instructorsCount = $group->count();
        //         // Calculate the sum of courses count for each instructor group
        //         $coursesCount = $group->sum('courses_count');
        //         return compact('instructorsCount', 'coursesCount');
        // });

        $instructors_menu = User::whereHasRoles('instructor')->hasCourses()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $this->searchQuery . '%');
                });
            })
            ->withCount(['courses' => function ($query) {
                $query->where('section', 1); // Count only courses where section is 1
            }])
            ->get()
            ->groupBy(function ($user) {
                return $user->first_name . ' ' . $user->last_name;
            })
            ->map(function ($group) {
                // Calculate the count of instructors in each group
                $instructorsCount = $group->count();
                // Calculate the sum of courses count for each instructor group
                $coursesCount = $group->sum('courses_count');
                return compact('instructorsCount', 'coursesCount');
            });




        switch ($this->sortingBy) {
            case 'popularity':
                $sort_field = "id";
                $sort_type = "asc";
                break;
            case 'new-courses':
                $sort_field = "created_at";
                $sort_type = "asc";
                break;

            case 'low-high':
                $sort_field = "price";
                $sort_type = "asc";
                break;

            case 'high-low':
                $sort_field = "price";
                $sort_type = "desc";
                break;

            default:
                $sort_field = "id";
                $sort_type = "asc";
        }

        $courses = Course::with('photos', 'firstMedia')->Course();
        if ($this->slug == null) {
            $courses = $courses->ActiveCourseCategory();
            if ($this->categoryInputs != null) {
                $courseCategoryIds = CourseCategory::whereIn('slug->' . app()->getLocale(), $this->categoryInputs)->pluck('id')->toArray();
                $courses = $courses->whereIn('course_category_id', $courseCategoryIds);
            }
        } else {

            if ($this->categoryInputs == null) {
                // $courseCategoryIds = CourseCategory::whereIn('slug->' . app()->getLocale(), $this->slug)->pluck('id')->toArray();
                $course_category = CourseCategory::where('slug->' . app()->getLocale(), $this->slug)
                    ->whereStatus(true)
                    ->first();
                $courses = $courses->where('course_category_id', $course_category->id);
            } else {
                $courseCategoryIds = CourseCategory::whereIn('slug->' . app()->getLocale(), $this->categoryInputs)->pluck('id')->toArray();
                $courses = $courses->whereIn('course_category_id', $courseCategoryIds);
            }
        }


        $instructor_ids = User::when($this->selectedNames, function ($query) {
            return $query->where(function ($subQuery) {
                foreach ($this->selectedNames as $fullName) {
                    $subQuery->orWhereRaw('CONCAT(first_name, " ", last_name) LIKE ?', ["%{$fullName}%"]);
                }
            });
        })->pluck('id')->toArray();

        $courses = $courses->active()
            ->when($this->courseLevels, function ($query) {
                $query->whereIn('skill_level', $this->courseLevels);
            })
            ->when($this->priceInput, function ($query) {
                $query
                    ->when($this->priceInput == 'all', function ($query2) {
                        $query2->where('price', '>=', 0);
                    })
                    ->when($this->priceInput == 'free', function ($query2) {
                        $query2->where('price', '=', 0);
                    })
                    ->when($this->priceInput == 'paid', function ($query2) {
                        $query2->where('price', '>', 0);
                    });
            })
            ->when($this->selectedNames, function ($query) use ($instructor_ids) {
                return $query->whereHas('users', function ($subQuery) use ($instructor_ids) {
                    $subQuery->whereIn('user_id', $instructor_ids);
                });
            })

            ->when($this->selectedRatings, function ($query) {
                // Filter courses based on average reviews rating
                $query->whereHas('reviews', function ($subQuery) {
                    // Calculate the average rating
                    $subQuery->selectRaw('avg(rating) as average_rating')
                        ->groupBy('reviewable_id');
                    // Filter courses where the average rating is >= any of the selected ratings
                    $subQuery->havingRaw('max(rating) >= ?', [min($this->selectedRatings)]);
                });
            })

            ->orderBy($sort_field, $sort_type)
            ->paginate($this->paginationLimit);




        // $course_categories_menu = CourseCategory::withCount('courses')->has('courses')->get();
        $course_categories_menu = CourseCategory::withCount(['courses' => function ($query) {
            return $query->where('section', 1);
        }])->has('courses')->get();

        $menuCounts = Course::where('section', 1)->get();

        return view('livewire.frontend.courses.course-list-component', [
            'courses'   =>  $courses,
            'course_categories_menu' => $course_categories_menu,
            'sortingBy' => $this->sortingBy,
            'instructors_menu'    =>  $instructors_menu,
            'menuCounts'            => $menuCounts,
        ]);
    }
}
