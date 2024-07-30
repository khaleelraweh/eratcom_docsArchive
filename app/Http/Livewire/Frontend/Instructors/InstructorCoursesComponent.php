<?php

namespace App\Http\Livewire\Frontend\Instructors;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class InstructorCoursesComponent extends Component
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

    public $selectedRatings = [];

    protected $queryString = ['categoryInputs', 'courseLevels', 'priceInput', 'searchQuery', 'selectedRatings'];

    public function resetFilters()
    {
        $this->sortingBy = "default";
        $this->priceInput = '';
        $this->courseLevels = [];
        $this->categoryInputs = [];

        $this->searchQuery = '';
        $this->selectedRatings = [];
    }


    public function render()
    {

        //Get this auth user id
        $userId = auth()->id();
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


        $courses = $courses
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
            ->whereHas('users', function ($query) {
                return $query->where('user_id', Auth()->user()->id);
            })
            ->orderBy($sort_field, $sort_type)
            ->paginate($this->paginationLimit);


        //Get all course categories related to this auth user 


        $course_categories_menu = CourseCategory::withCount(['courses' => function ($query) use ($userId) {
            $query->whereHas('users', function ($query2) use ($userId) {
                $query2->where('user_id', $userId);
            });
        }])->whereHas('courses', function ($query) use ($userId) {
            $query->whereHas('users', function ($query2) use ($userId) {
                $query2->where('user_id', $userId);
            });
        })->get();

        $menuCounts = Course::where('section', 1)->whereHas('users', function ($query) {
            return $query->where('user_id', Auth()->user()->id);
        })->get();


        return view('livewire.frontend.instructors.instructor-courses-component', [
            'courses'   =>  $courses,
            'course_categories_menu' => $course_categories_menu,
            'sortingBy' => $this->sortingBy,
            'menuCounts'    => $menuCounts,

        ]);
    }
}
