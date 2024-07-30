<?php

namespace App\Http\Livewire\Frontend\Instructors;

use App\Models\Course;
use App\Models\User;
use App\Notifications\Frontend\Instructor\CourseCreatedNotification;
use Illuminate\Support\Facades\Validator;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CourseDetailsConfirmationComponent extends Component
{

    use LivewireAlert;

    public $courseId;
    public $course;

    // public $sendViewStatus = false;


    // General validation 
    public $databaseDataValid           = false;
    public $courseLandingTabValid       = false;
    public $courseObjectiveTabValid     = false;
    public $courseCurriculumTabValid    = false;
    public $coursePricingTabValid       = false;  //doen 
    public $coursePublishedTabValid     = false; //done 



    // Field validation 
    public $titleValid = false;
    public $subtitleValid = false;
    public $descriptionValid = false;
    public $videopromoValid = false;
    public $courseImageValid = false;
    public $objectivesValid = false;
    public $requirementsValid = false;
    public $intendedsValid = false;
    public $sectionsValid = false;
    public $duration_30_minutes_Valid = false;
    public $totalLessonsValid = false;
    public $priceValid = false;
    public $published_onValid = false;
    public $statusValid = false;

    public $course_status_array = [];
    public $course_status;

    protected $listeners = [
        'updateCourseDEtailsConfirmation' => 'mount'
    ];



    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $this->course = Course::find($this->courseId);
        $this->validateDatabaseData($courseId);

        $this->course_status_array = [
            '0' => __('panel.course_new_course'),
            '1' => __('panel.course_completed'),
            '2' => __('panel.course_under_process'),
            '3' => __('panel.course_review_finished'),
            '4' => __('panel.course_published'),
            '5' => __('panel.coure_rejected'),
        ];

        $key = array_search($this->course->course_status, array_keys($this->course_status_array));

        foreach ($this->course_status_array as $k => $v) {
            if ($k <= $key) {
                unset($this->course_status_array[$k]);
            }
        }

        $this->course_status = $this->course->course_status;
    }


    public function updateCourseStatusHandler()
    {
        $course = Course::find($this->courseId);
        $course->course_status = $this->course_status;
        $course->save();

        if ($course->course_status == 4) {
            $course->update(['status' => true]);
        } else if ($course->course_status == 5) {
            $course->update(['status' => false]);
        }

        session()->flash('message', 'Course status updated successfully.');
        $this->refreshData(); // Refresh data after updating the status
    }

    public function refreshData()
    {
        $this->mount($this->courseId);
    }

    //no nead fo sending the $courseId in this fuction but it is ok if you do it 
    protected function validateDatabaseData($courseId)
    {

        $this->validateCourseLanding();
        $this->validateObjective();
        $this->validateCurriculum();
        $this->validatePricing();
        $this->validatePublishData();


        $validations = [
            $this->courseLandingTabValid,
            $this->courseObjectiveTabValid,
            $this->courseCurriculumTabValid,
            $this->coursePricingTabValid,
            $this->coursePublishedTabValid,
        ];


        $completedValidations = count(array_filter($validations));
        $totalValidations = count($validations);
        $progressPercentage = ($completedValidations / $totalValidations) * 100;

        $this->databaseDataValid = $completedValidations === $totalValidations;


        $course = $this->course;

        $course->update([
            'progress' => $progressPercentage
        ]);

        if ($progressPercentage == 100) {
            if ($course->course_status <= 1) {
                $course->update([
                    'course_status'  => Course::COURSE_COMPLETED,
                ]);
            }
        }


        return $progressPercentage;
    }

    public function render()
    {
        return view(
            'livewire.frontend.instructors.course-details-confirmation-component',
            [
                'course' => $this->course,
                'course_status_array' => $this->course_status_array,
            ]
        );
    }

    protected function validateField($value, $field, $rules)
    {
        $validator = Validator::make([$field => $value], [$field => $rules]);
        return !$validator->fails();
    }

    protected function validateCollection($collection, $field, $rules, $minCount = 0)
    {
        if ($collection->count() < $minCount) {
            return false;
        }

        foreach ($collection as $item) {
            if (!$this->validateField($item->{$field}, $field, $rules)) {
                return false;
            }
        }
        return true;
    }


    protected function validateCourseLanding()
    {
        $course = $this->course;

        $this->titleValid = $this->validateField($course->title, 'title', ['required', 'string', 'min:10', 'max:60']);
        $this->subtitleValid = $this->validateField($course->subtitle, 'subtitle', ['required', 'string', 'min:10', 'max:120']);
        $this->descriptionValid = $this->validateField($course->description, 'description', ['required', 'string', 'min_words:100']);
        $this->videopromoValid = $this->validateField($course->video_promo, 'video_promo', ['required', 'url', 'min:10']);

        $this->courseImageValid = $course->firstMedia && file_exists(public_path('assets/courses/' . $course->firstMedia->file_name));

        $this->courseLandingTabValid = $this->titleValid && $this->subtitleValid && $this->descriptionValid && $this->videopromoValid && $this->courseImageValid;
    }

    protected function validateObjective()
    {
        $course = $this->course;

        $this->objectivesValid = $this->validateCollection($course->objectives, 'title', ['required', 'string', 'min:10', 'max:160'], 4);
        $this->requirementsValid = $this->validateCollection($course->requirements, 'title', ['required', 'string', 'min:10', 'max:160'], 1);
        $this->intendedsValid = $this->validateCollection($course->intendeds, 'title', ['required', 'string', 'min:10', 'max:160'], 1);

        $this->courseObjectiveTabValid = $this->objectivesValid && $this->requirementsValid && $this->intendedsValid;
    }

    protected function validateCurriculum()
    {
        $course = $this->course;

        $this->sectionsValid = $this->validateCollection($course->sections, 'title', ['required', 'string', 'min:3', 'max:80']);

        // $duration_30_minutes_Valid = $course->sections->reduce(function ($carry, $section) {
        //     return $carry + $section->lessons->sum('duration_minutes');
        // }, 0) >= 30;
        // $this->duration_30_minutes_Valid = $duration_30_minutes_Valid;

        $this->totalLessonsValid = $course->totalLessonsCount() >= 5;

        // duration validation more than or equal to 30 minutes 
        $duration_30_minutes_Valid = true;
        $totalDurations = 0;
        foreach ($course->sections as $section) {
            $totalDurations += $section->lessons->sum(
                'duration_minutes',
            );
        }
        if ($totalDurations < 30) {
            $duration_30_minutes_Valid = false;
        }
        $this->duration_30_minutes_Valid = $duration_30_minutes_Valid;

        $this->courseCurriculumTabValid = $this->sectionsValid && $this->duration_30_minutes_Valid && $this->totalLessonsValid;
    }

    protected function validatePricing()
    {
        $course = $this->course;

        $this->priceValid = $this->validateField($course->price, 'price', ['required', 'numeric', 'min:0']);
        $this->coursePricingTabValid = $this->priceValid;
    }

    protected function validatePublishData()
    {
        $course = $this->course;

        $this->published_onValid = $this->validateField($course->published_on, 'published_on', ['required']);
        $this->statusValid = $this->validateField($course->status, 'status', ['required', 'numeric', 'min:0']);

        $this->coursePublishedTabValid = $this->published_onValid && $this->statusValid;
    }

    public function sendForReview()
    {
        $course = $this->course;

        $course->update([
            'course_status'   =>  Course::UNDER_PROCESS,
        ]);

        $admins = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin', 'supervisor']);
        })->get();

        foreach ($admins as $admin) {
            $admin->notify(new CourseCreatedNotification($course));
        }


        // $this->sendViewStatus = true;

        $this->alert('success', __('transf.Course send for admin review successfully!'));
    }
}
