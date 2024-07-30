<?php

namespace App\Http\Livewire\Frontend\Courses;

use App\Models\Course;
use Livewire\Component;

class ReviewComponent extends Component
{

    public $courseId;

    protected $listeners = [
        'reviewAdded' => 'render'
    ];


    public function render()
    {
        $course = Course::with('reviews')->find($this->courseId);
        $totalReviews = $course->reviews->count();
        $totalRatings = $course->reviews->sum('rating');

        // Calculate the average rating
        $averageRating = $totalReviews > 0 ? $totalRatings / $totalReviews : 0;

        $reviews = $course->reviews;

        return view('livewire.frontend.courses.review-component', compact('reviews', 'averageRating'));
    }
}
