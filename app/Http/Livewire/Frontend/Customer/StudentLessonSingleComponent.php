<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Models\Course;
use Livewire\Component;

class StudentLessonSingleComponent extends Component
{
    public $slug;
    public $videoUrl;
    public $selectedLessonUrl;


    public function mount()
    {
        $course = Course::with('sections.lessons')->where('slug->' . app()->getLocale(), $this->slug)->first();
        $url = $course->sections->first()->lessons->first()->url;

        if (empty($this->videoUrl)) {
            $this->videoUrl = $url;
            $this->selectedLessonUrl = $url; // Initialize the selected lesson URL

        }
    }

    public function render()
    {
        $course = Course::with('sections.lessons')->where('slug->' . app()->getLocale(), $this->slug)->first();
        // Calculate total duration for each section
        $totalDurations = [];
        foreach ($course->sections as $section) {
            $totalDuration = $section->lessons->sum('duration_minutes');
            $totalDurations[$section->id] = $totalDuration;
        }

        return view('livewire.frontend.customer.student-lesson-single-component', compact('course', 'totalDurations'));
    }

    public function updateVideoUrl($url)
    {
        $this->videoUrl = $url;
        $this->selectedLessonUrl = $url; // Update the selected lesson URL

    }
}
