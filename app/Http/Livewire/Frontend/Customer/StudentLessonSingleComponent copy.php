<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Models\Course;
use Livewire\Component;

class StudentLessonSingleComponent extends Component
{
    public $slug;

    public $videoUrl;

    public function render()
    {
        $course = Course::with('sections.lessons')->where('slug->' . app()->getLocale(), $this->slug)->first();

        // Trim the text to remove leading and trailing spaces
        $course->description = trim($course->description);
        // Get the first 200 characters
        $exposedText = substr($course->description, 0, 200);
        // Get the rest of the text
        $hiddenText = substr($course->description, 200);

        // Calculate total duration for each section
        $totalDurations = [];
        foreach ($course->sections as $section) {
            $totalDuration = $section->lessons->sum('duration_minutes');
            $totalDurations[$section->id] = $totalDuration;
        }

        return view('livewire.frontend.customer.student-lesson-single-component', compact('course', 'totalDurations', 'exposedText', 'hiddenText'));
    }

    public function updateVideoUrl($url)
    {
        $this->videoUrl = $url;

        // Refresh the Livewire component to update the video
        $this->render();
    }
}
