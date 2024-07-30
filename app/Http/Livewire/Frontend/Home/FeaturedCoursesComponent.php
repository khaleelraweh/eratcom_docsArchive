<?php

namespace App\Http\Livewire\Frontend\Home;

use App\Models\Course;
use App\Models\CourseCategory;
use Livewire\Component;

class FeaturedCoursesComponent extends Component
{

    public  $amount = 8;
    public $featured_courses;
    public $showMoreBtn = false;
    public $showLessBtn = false;

    //To filter by categories choosen 
    public $categoryInputs;

    // To filter by levels 
    public $courseLevels;

    // To filter by price 
    public $priceInput;

    //To sort by 
    public $sortingBy = "default";

    protected $queryString = ['categoryInputs', 'courseLevels', 'priceInput'];


    public function resetFilters()
    {
        $this->sortingBy = "default";
        $this->priceInput = '';
        $this->courseLevels = [];
        $this->categoryInputs = [];
    }



    public function render()
    {

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


        $course_categories_menu = CourseCategory::withCount('courses')->get();

        // $featured_courses = Course::with('firstMedia', 'lastMedia', 'courseCategory')->inRandomOrder()->Active()->ActiveCourseCategory()
        $this->featured_courses = Course::with('firstMedia', 'lastMedia', 'courseCategory', 'users', 'reviews')
            ->inRandomOrder()
            ->Active()
            ->Course()
            ->ActiveCourseCategory()
            ->when($this->categoryInputs, function ($query) {
                $query->where('course_category_id', $this->categoryInputs);
            })
            ->when($this->courseLevels, function ($query) {
                $query->where('skill_level', $this->courseLevels);
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
            ->orderBy($sort_field, $sort_type)
            ->get();

        if (count($this->featured_courses) > 8) {
            $this->showMoreBtn = true;
            if ($this->amount > 8) {
                if (count($this->featured_courses) <= $this->amount) {
                    $this->showLessBtn = true;
                    $this->showMoreBtn = false;
                } else {
                    $this->showLessBtn = true;
                }
            } else {
                $this->showLessBtn = false;
            }
        } else {
            $this->showMoreBtn = false;
        }




        return view(
            'livewire.frontend.home.featured-courses-component',
            [
                'featured_courses'  =>  $this->featured_courses,
                'course_categories_menu'    =>  $course_categories_menu,
                'sortingBy' => $this->sortingBy,
            ]
        );
    }

    public function load_more()
    {
        $this->amount += 4;
    }

    public function load_less()
    {
        $this->amount -= 4;
    }
}
