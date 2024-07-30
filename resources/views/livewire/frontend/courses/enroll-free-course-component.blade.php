<div>




    @php
        $userId = auth()->id();

        $course = App\Models\Course::whereId($courseId)->firstOrFail();

        // Check if the user is already enrolled in the course
        $isEnrolled = App\Models\Order::where('user_id', $userId)
            ->whereHas('courses', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->exists();

    @endphp

    @if ($course->isInstructor($userId))

        <a href="{{ route('instructor.courses.edit', $course->id) }}"
            class="btn btn-blue btn-block mb-6">{{ __('transf.btn_go_to_your_course_dashboard') }}</a>
    @else
        @if ($isEnrolled)
            <a href="{{ route('customer.lesson_single', $course->slug) }}"
                class="btn btn-blue btn-block mb-6">{{ __('transf.btn_go_to_course') }}</a>
        @else
            <button wire:click.prevent="enrollCourse()" class="btn btn-orange btn-block mb-6" type="button"
                name="button">{{ __('transf.btn_enroll') }}</button>
        @endif
    @endif


</div>
