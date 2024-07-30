<?php

namespace App\Http\Livewire\Frontend\Instructors;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Objective;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;


class IntendedLearnersComponent extends Component
{
    use LivewireAlert;

    public $courseId;
    public $objectives = [];
    public $requirements = [];
    public $intendeds = [];

    public $formSubmitted = false;
    public $databaseDataValid = false;

    public $objectivesValid = false;
    public $requirementsValid = false;
    public $intendedsValid = false;



    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $course = Course::where('id', $this->courseId)->first();

        // Initialize objectives
        if ($course->objectives != null && $course->objectives->isNotEmpty()) {
            foreach ($course->objectives as $item) {
                $this->objectives[] = ['title' => $item->title];
            }
        } else {
            $this->objectives = [
                ['title' => ''],
                ['title' => ''],
                ['title' => ''],
                ['title' => ''],
            ];
        }

        // Initialize Requirements
        if ($course->requirements != null && $course->requirements->isNotEmpty()) {
            foreach ($course->requirements as $item) {
                $this->requirements[] = ['title' => $item->title];
            }
        } else {
            $this->requirements = [
                ['title' => ''],
            ];
        }

        // Initialize Intendeds
        if ($course->intendeds != null && $course->intendeds->isNotEmpty()) {
            foreach ($course->intendeds as $item) {
                $this->intendeds[] = ['title' => $item->title];
            }
        } else {
            $this->intendeds = [
                ['title' => ''],
            ];
        }

        // Validate database data
        $this->validateDatabaseData();
    }

    protected function validateDatabaseData()
    {
        // Validate objectives
        $objectivesValid = true;
        $course = Course::where('id', $this->courseId)->first();
        $objectivesCount = $course->objectives->count();
        if ($objectivesCount >= 4) {
            foreach ($course->objectives as $item) {
                $validator = Validator::make(['title' => $item->title], [
                    'title' => ['required', 'string', 'min:10', 'max:160'],
                ]);
                if ($validator->fails()) {
                    $objectivesValid = false;
                    break;
                }
            }
        } else {
            $objectivesValid = false;
        }

        // Validate requirements
        $requirementsValid = true;
        $requirementsCount = $course->requirements->count();
        if ($requirementsCount >= 1) {
            foreach ($course->requirements as $item) {
                $validator = Validator::make(['title' => $item->title], [
                    'title' => ['required', 'string', 'min:10', 'max:160'],
                ]);
                if ($validator->fails()) {
                    $requirementsValid = false;
                    break;
                }
            }
        } else {
            $requirementsValid = false;
        }

        // Validate intendeds
        $intendedsValid = true;
        $intendedsCount = $course->intendeds->count();
        if ($intendedsCount >= 1) {
            foreach ($course->intendeds as $item) {
                $validator = Validator::make(['title' => $item->title], [
                    'title' => ['required', 'string', 'min:10', 'max:160'],
                ]);
                if ($validator->fails()) {
                    $intendedsValid = false;
                    break;
                }
            }
        } else {
            $intendedsValid = false;
        }

        // Set flags for objectives and requirements validation
        $this->databaseDataValid = $objectivesValid && $requirementsValid && $intendedsValid;

        $this->objectivesValid = $objectivesValid;
        $this->requirementsValid = $requirementsValid;
        $this->intendedsValid = $intendedsValid;
    }


    // add Objective 
    public function addObjective()
    {
        $this->objectives[] = ['title' => ''];
    }

    //add Requirement
    public function addRequirement()
    {
        $this->requirements[] = ['title' => ''];
    }

    //add Intended
    public function addIntended()
    {
        $this->intendeds[] = ['title' => ''];
    }

    // remove Objective
    public function removeObjective($index)
    {
        unset($this->objectives[$index]);
        $this->objectives = array_values($this->objectives);
    }

    // remove Requirement
    public function removeRequirement($index)
    {
        unset($this->requirements[$index]);
        $this->requirements = array_values($this->requirements);
    }

    // remove Intended
    public function removeIntended($index)
    {
        unset($this->intendeds[$index]);
        $this->intendeds = array_values($this->intendeds);
    }

    public function render()
    {
        $course = Course::where('id', $this->courseId)->first();
        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);

        // Get active instructor
        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->active()->get(['id', 'first_name', 'last_name']);


        $courseinstructors = $course->users->pluck(['id'])->toArray();

        return view('livewire.frontend.instructors.intended-learners-component', compact('course_categories', 'course', 'instructors', 'courseinstructors'));
    }

    // public function storeObjective()
    public function storeIntended()
    {
        // Validate objectives and requirements
        $this->validate([
            'objectives' => ['required', 'array', 'min:4'],
            'objectives.*.title' => ['required', 'string', 'min:10', 'max:160'],
            'requirements' => ['required', 'array', 'min:1'],
            'requirements.*.title' => ['required', 'string', 'min:10', 'max:160'],
            'intendeds' => ['required', 'array', 'min:1'],
            'intendeds.*.title' => ['required', 'string', 'min:10', 'max:160'],
        ], [
            'objectives.required' => __('transf.At least four objectives are required.'),
            'objectives.min' => __('transf.At least four objectives are required.'),
            'objectives.*.title.required' => __('transf.The objective field is required.'),
            'objectives.*.title.string' => __('transf.The objective must be a string.'),
            'objectives.*.title.min' => __('transf.The objective must be at least ten characters.'),
            'objectives.*.title.max' => __('transf.The objective must not exceed 160 characters.'),
            'requirements.required' => __('transf.At least one requirement is required.'),
            'requirements.min' => __('transf.At least one requirement is required.'),
            'requirements.*.title.required' => __('transf.The requirement field is required.'),
            'requirements.*.title.string' => __('transf.The requirement must be a string.'),
            'requirements.*.title.min' => __('transf.The requirement must be at least ten characters.'),
            'requirements.*.title.max' => __('transf.The requirement must not exceed 160 characters.'),
            'intendeds.required' => __('transf.At least one intended is required.'),
            'intendeds.min' => __('transf.At least one intended is required.'),
            'intendeds.*.title.required' => __('transf.The intended field is required.'),
            'intendeds.*.title.string' => __('transf.The intended must be a string.'),
            'intendeds.*.title.min' => __('transf.The intended must be at least ten characters.'),
            'intendeds.*.title.max' => __('transf.The intended must not exceed 160 characters.'),
        ]);

        // Store objectives and requirements
        $course = Course::where('id', $this->courseId)->first();

        $course->objectives()->delete();
        if ($this->objectives != null) {
            $course->objectives()->createMany($this->objectives);
        }

        $course->requirements()->delete();
        if ($this->requirements != null) {
            $course->requirements()->createMany($this->requirements);
        }

        $course->intendeds()->delete();
        if ($this->intendeds != null) {
            $course->intendeds()->createMany($this->intendeds);
        }

        // Set $databaseDataValid to true
        $this->databaseDataValid = true;

        // Set formSubmitted to true on successful submission
        $this->formSubmitted = true;

        $this->emit('updateCourseDEtailsConfirmation', $this->courseId);

        // Show success alert
        $this->alert('success', __('transf.intended_learners') . ' ' . __('transf.completed_successfully!'));
    }
}
