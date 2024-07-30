<?php

namespace App\Http\Livewire\Frontend\Home;

use App\Models\CourseCategory;
use Livewire\Component;

class TrendingCategoriesComponent extends Component
{

    public  $amount = 8;
    public $course_categories;
    public $showMoreBtn = false;
    public $showLessBtn = false;


    public function render()
    {
        $this->course_categories = CourseCategory::with('firstMedia')
            ->HasCourses()
            ->Active()
            ->RootCategory()
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($this->course_categories) > 8) {
            $this->showMoreBtn = true;
            if ($this->amount > 8) {
                if (count($this->course_categories) <= $this->amount) {
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
            'livewire.frontend.home.trending-categories-component',
            [
                'course_categories' => $this->course_categories,
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
