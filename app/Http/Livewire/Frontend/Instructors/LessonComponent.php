<?php

namespace App\Http\Livewire\Frontend\Instructors;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class LessonComponent extends Component
{

    use LivewireAlert;

    public $courseId;
    public $sections = [];

    public $formSubmitted = false;
    public $databaseDataValid = false;

    public $sectionsValid = false;
    public $duration_30_minutes_Valid = false;
    public $totalLessonsValid = false;


    // Property to track the edit state of section title
    public $editSectionTitleIndex = null;



    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $course = Course::findOrFail($this->courseId);

        // Initialize sections
        if ($course->sections != null && $course->sections->isNotEmpty()) {
            foreach ($course->sections as $section) {
                $sectionData = [
                    'title' => $section->title,
                    'sectionId' => $section->id,
                    'lessons' => [],
                    'saved' => true,
                ];
                if ($section->lessons != null && $section->lessons->isNotEmpty()) {
                    // Populate lessons for each section
                    foreach ($section->lessons as $lesson) {
                        $sectionData['lessons'][] = [
                            'title' => $lesson->title,
                            'url' => $lesson->url,
                            'duration_minutes' => $lesson->duration_minutes,
                        ];
                    }
                } else {
                    $sectionData = [
                        'sectionId' => $section->id,
                        'title' => $section->title,
                        'lessons' => [
                            ['title' => '', 'url' => '', 'duration_minutes' => ''],

                        ],
                        'saved' => true, // Track if section has been saved
                    ];
                }

                $this->sections[] = $sectionData;
            }
        } else {
            // If there are no sections, create a default section
            $this->sections = [
                [
                    'title' => 'Introduction',
                    'sectionId' => -1,
                    'lessons' => [],

                    'saved' => false, // Track if section has been saved
                ],
            ];
        }

        // Validate database data
        $this->validateDatabaseData();
    }



    // Method to toggle the edit state of section title input field
    public function toggleEditSectionTitle($index)
    {
        $this->editSectionTitleIndex = $index;
    }


    // Method to update the section title
    public function updateSectionTitle($index)
    {
        $section = CourseSection::find($this->sections[$index]['sectionId']);

        if ($section) {
            $section->update(['title' => $this->sections[$index]['title']]);
            $this->editSectionTitleIndex = null; // Reset edit state
        }
    }



    protected function validateDatabaseData()
    {
        // Validate sections
        $sectionsValid = true;
        $course = Course::findOrFail($this->courseId);
        $sectionsCount = $course->sections->count();
        if ($sectionsCount > 0) {
            foreach ($course->sections as $section) {
                $validator = Validator::make(['title' => $section->title], [
                    'title' => ['required', 'string', 'min:3', 'max:80'],
                ]);
                if ($validator->fails()) {
                    $sectionsValid = false;
                    break;
                }
            }
        } else {
            $sectionsValid = false;
        }

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

        // lesson total more than 5 lectures 
        $totalLessonsValid = true;
        if ($course->totalLessonsCount() < 5) {
            $totalLessonsValid = false;
        }


        // Set flags for sections validation
        $this->databaseDataValid = $sectionsValid && $duration_30_minutes_Valid && $totalLessonsValid;

        $this->sectionsValid = $sectionsValid;
        $this->duration_30_minutes_Valid = $duration_30_minutes_Valid;
        $this->totalLessonsValid = $totalLessonsValid;
    }


    // Method to add a new section
    public function addSection()
    {
        $this->sections[] = [
            'title' => '', // Initialize title as empty
            'lessons' => [],
            'sectionId' => -1, // Set sectionId as -1 for new section
            'saved' => false, // Initialize saved as false
        ];
    }

    // Method to save the new section with provided title
    public function saveSection($index)
    {


        // Get the section data
        $sectionData = $this->sections[$index];

        // Validate the section title
        $validator = Validator::make(['title' => $sectionData['title']], [
            'title' => ['required', 'string', 'min:3', 'max:80'],
        ]);

        // If validation fails, show an error alert
        if ($validator->fails()) {
            $this->alert('error', __('transf.Section title validation failed!'));
            return;
        }


        // Check if the 'sectionId' key exists in the $sectionData array to only update the section title because it saved before 
        if (array_key_exists('sectionId', $sectionData) && $sectionData['sectionId'] !== -1) {
            // Update the existing section title
            $section = CourseSection::find($sectionData['sectionId']);
            if ($section) {
                $section->update(['title' => $sectionData['title']]);
                // Show success alert for updating section title
                $this->sections[$index]['saved'] = true;
                $this->alert('success', __('transf.Section title updated successfully!'));
            }
        } else {
            // Create a new section
            $section = CourseSection::create([
                'title' => $sectionData['title'],
                'slug' => Str::slug($sectionData['title']),
                'course_id' => $this->courseId,
            ]);



            // Update the sectionId with the newly created section's id
            $sectionData = [
                'sectionId' => $section->id,
                'title' => $section->title,
                'lessons' => [
                    ['title' => '', 'url' => '', 'duration_minutes' => ''],
                ],
                'saved' => true, // Track if section has been saved
            ];

            $this->sections[$index] = $sectionData;
            $this->sections[$index]['saved'] = true; // Mark section as saved


            // Show success alert for creating new section
            $this->alert('success', __('transf.New section created successfully!'));
        }

        $this->editSectionTitleIndex = null;

        $this->updateSectionTitle($index);

        // Save lessons for the section
        // $this->saveLessonsInSection($index);

        // we are here
        $this->emit('updateCourseDEtailsConfirmation', $this->courseId);
    }



    // Method to save lessons for a specific section
    public function saveLessonsInSection($index)
    {

        // Get the section data
        $sectionData = $this->sections[$index];

        // Validate lessons for the section
        $validator = Validator::make($sectionData['lessons'], [
            '*.title' => ['required', 'string', 'min:10', 'max:160'],
            // '*.url' => ['required', 'url'],
            '*.duration_minutes' => ['required', 'integer', 'min:1'],
        ]);

        // If validation fails, show an error alert
        if ($validator->fails()) {
            $this->alert('error', __('transf.Lesson data validation failed!'));
            return;
        }

        // Get the section
        $section = CourseSection::find($sectionData['sectionId']);

        // If the section is found
        if ($section) {
            // Delete existing lessons for the section
            $section->lessons()->delete();

            // Create lessons for the section
            foreach ($sectionData['lessons'] as $lessonData) {
                $lesson = new Lesson($lessonData);
                $section->lessons()->save($lesson);
            }

            // Validate database data
            $this->validateDatabaseData();

            $this->emit('updateCourseDEtailsConfirmation', $this->courseId);

            // Show success alert
            $this->alert('success', __('transf.Lessons for the section saved successfully!'));
        }
    }



    // Method to remove a section along with its lessons
    public function removeSection($index)
    {
        // Check if the section exists in the sections array
        if (!isset($this->sections[$index])) {
            $this->alert('error', 'Section not found!');
            return;
        }

        // Get the sectionId, if it exists
        $sectionId = $this->sections[$index]['sectionId'] ?? null;

        // If the section exists in the database, delete it along with its lessons
        if ($sectionId) {
            // Find the section
            $section = CourseSection::find($sectionId);

            // If the section is found, delete it
            if ($section) {
                // Delete the lessons associated with the section
                $section->lessons()->delete();

                // Delete the section itself
                $section->delete();
            }
        }

        // Remove the section from the sections array
        unset($this->sections[$index]);

        // Re-index the sections array
        $this->sections = array_values($this->sections);

        // Validate database data
        $this->validateDatabaseData();

        $this->emit('updateCourseDEtailsConfirmation', $this->courseId);

        $this->alert('success', __('transf.Section removed successfully!'));
    }


    public function render()
    {
        $course = Course::findOrFail($this->courseId);
        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);

        // Get active instructor
        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->active()->get(['id', 'first_name', 'last_name']);

        return view('livewire.frontend.instructors.lesson-component', compact('course_categories', 'course', 'instructors'));
    }

    public function storeSections()
    {
        // Validate sections
        $this->validate([
            'sections' => ['required', 'array', 'min:1'],
            'sections.*.title' => ['required', 'string', 'min:10', 'max:160'],
        ], [
            'sections.required' => __('transf.At least one section is required.'),
            'sections.min' => __('transf.At least one section is required.'),
            'sections.*.title.required' => __('transf.The section title is required.'),
            'sections.*.title.string' => __('transf.The section title must be a string.'),
            'sections.*.title.min' => __('transf.The section title must be at least ten characters.'),
            'sections.*.title.max' => __('transf.The section title must not exceed 160 characters.'),
        ]);

        // Loop through each section in the form
        foreach ($this->sections as $index => $sectionData) {
            // If the section doesn't have a valid sectionId, create a new section
            if ($sectionData['sectionId'] == -1) {
                $section = CourseSection::create([
                    'title' => $sectionData['title'], // Use the provided title
                    'slug' => Str::slug($sectionData['title']), // Generate slug from title
                    'course_id' => $this->courseId,
                ]);
                $this->sections[$index]['sectionId'] = $section->id; // Update the sectionId
            } else {
                // If the section already exists, update its title
                $section = CourseSection::find($sectionData['sectionId']);
                if ($section) {
                    $section->update(['title' => $sectionData['title']]);
                }
            }

            // If the section is found or created, update its lessons
            if ($section) {
                // Delete existing lessons for the section
                $section->lessons()->delete();

                // Create lessons for the section
                foreach ($sectionData['lessons'] as $lessonData) {
                    // Check if the lesson title is not empty
                    if (!empty($lessonData['title'])) {
                        $lesson = new Lesson($lessonData);
                        $section->lessons()->save($lesson);
                    }
                }
            }
        }

        // Mark saved sections as not saved to enable editing
        // لاغلاق جميع الاقسام 
        foreach ($this->sections as $index => $section) {
            if ($section['saved']) {
                $this->sections[$index]['saved'] = false;
            }
        }

        $this->validateDatabaseData();

        $this->emit('updateCourseDEtailsConfirmation', $this->courseId);

        // Set formSubmitted to true on successful submission
        $this->formSubmitted = true;

        // Show success alert
        $this->alert('success', __('transf.Sections updated successfully!'));
    }




    public function addLesson($sectionIndex)
    {

        $this->sections[$sectionIndex]['lessons'][] = ['title' => '', 'url' => '', 'duration_minutes' => ''];
    }

    public function removeLesson($sectionIndex, $lessonIndex)
    {
        unset($this->sections[$sectionIndex]['lessons'][$lessonIndex]);
        $this->sections[$sectionIndex]['lessons'] = array_values($this->sections[$sectionIndex]['lessons']);
    }
}
