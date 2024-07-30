<div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center">
                @if ($databaseDataValid && !$errors->any())
                    <div class="mb-4">
                        <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                    </div>
                    <div>

                        <h5>{{ __('transf.Course Data Confirmed successfully') }}</h5>
                        <p class="text-muted">{{ __('transf.Course Data Confirmed successfully tips') }}</p>

                        {{-- @if (!$sendViewStatus || !$course->send_for_review == true) --}}
                        @if ($course->course_status == 1)
                            <button class="btn btn-sm btn-primary px-2 py-2" wire:click.prevent="sendForReview()">
                                {{ __('transf.Send For Review') }}
                            </button>
                        @endif

                        <div>

                            @if ($course->course_status == 2)
                                <span
                                    class="d-flex justify-content-center align-items-center bg-info  px-1 py-2 text-white border rounded">
                                    <i class="mdi mdi-book-open-page-variant text-white display-6 me-3"></i>
                                    {{ __('transf.Course send for admin review successfully!') }}
                                </span>
                            @endif
                            @if ($course->course_status == 3)
                                <span
                                    class="d-flex justify-content-center align-items-center bg-info  px-1 py-2 text-white border rounded">
                                    <i class="mdi mdi-check-circle-outline text-white display-6 me-3"></i>
                                    {{ __('transf.Course review finished by adminstration successfully!') }}
                                </span>
                            @endif
                            @if ($course->course_status == 4)
                                <span
                                    class="d-flex justify-content-center align-items-center bg-info  px-1 py-2 text-white border rounded">
                                    <i class="mdi mdi-check-circle-outline text-white display-6 me-3"></i>
                                    {{ __('transf.The course was successfully accepted and published by the administration') }}
                                </span>
                            @endif
                            @if ($course->course_status == 5)
                                <span
                                    class="d-flex justify-content-center align-items-center bg-info  px-1 py-2 text-white border rounded">
                                    <i class="mdi mdi-alert-circle text-white display-6 me-3"></i>
                                    {{ __('transf.The course was rejected because it did not meet our publishing standards. Please check the course contents and try again') }}
                                </span>

                                <button class="btn btn-sm btn-primary px-2 py-2 mt-3"
                                    wire:click.prevent="sendForReview()">
                                    {{ __('transf.Resend For New Review') }}
                                </button>
                            @endif

                            @if ($course->course_status >= 2)

                                @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('supervisor'))
                                    <div class="mt-3">
                                        <form wire:submit.prevent="updateCourseStatusHandler">
                                            <div class="form-row align-items-center">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ __('panel.course_status') }}
                                                        </div>
                                                    </div>
                                                    <select wire:model="course_status"
                                                        wire:change="updateCourseStatusHandler"
                                                        style="outline-style:none;" class="form-control">
                                                        <option value="">
                                                            {{ __('panel.course_choose_appropriate_event') }}</option>
                                                        @foreach ($course_status_array as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif

                                {{-- @if (session()->has('message'))
                                    <div class="alert alert-success mt-2">
                                        {{ session('message') }}
                                    </div>
                                @endif --}}

                            @endif
                        </div>


                    </div>
                @else
                    <div class="mb-4">
                        <i class="mdi mdi-alert-circle-outline text-warning display-4"></i>
                    </div>
                    <div>

                        <h5>{{ __('transf.Confirm the compulsory course information') }}</h5>
                        <p class="text-muted">{{ __('transf.Confirm the compulsory course information tips') }}</p>

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
