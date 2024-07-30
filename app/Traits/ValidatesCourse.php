<?php

namespace App\Traits;

use App\Models\Course;

trait ValidatesCourse
{
    public function validateCourseLanding($course)
    {
        // Your validation logic here
        $course->courseLandingTabValid = true; // Example
    }

    public function validateObjective($course)
    {
        // Your validation logic here
        $course->courseObjectiveTabValid = true; // Example
    }

    public function validateCurriculum($course)
    {
        // Your validation logic here
        $course->courseCurriculumTabValid = true; // Example
    }

    public function validatePricing($course)
    {
        // Your validation logic here
        $course->coursePricingTabValid = true; // Example
    }

    public function validatePublishData($course)
    {
        // Your validation logic here
        $course->coursePublishedTabValid = true; // Example
    }

    public function validateDatabaseData($course)
    {
        $this->validateCourseLanding($course);
        $this->validateObjective($course);
        $this->validateCurriculum($course);
        $this->validatePricing($course);
        $this->validatePublishData($course);

        return $course->courseLandingTabValid &&
            $course->courseObjectiveTabValid &&
            $course->courseCurriculumTabValid &&
            $course->coursePricingTabValid &&
            $course->coursePublishedTabValid;
    }
}
