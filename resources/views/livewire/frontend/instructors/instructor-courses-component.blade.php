<style>
    .khaleel {
        position: relative;
        overflow: hidden;
    }

    .overlay {
        cursor: pointer;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .khaleel:hover .overlay {
        opacity: 1;
    }
</style>




<div>

    {{-- CONTROL BAR --}}
    <div class="container mb-6 mb-xl-8 z-index-2">
        <div class="d-lg-flex align-items-center mb-6 mb-xl-0">

            <p class="mb-lg-0">
                {{ __('transf.txt_we_found') }}
                <span class="text-dark">{{ $courses->total() }}
                    {{ __('transf.of_courses') }}
                </span>
                {{ __('transf.txt_related_to_you') }}
            </p>
            <div class="ms-lg-auto d-lg-flex flex-wrap">
                <div class="mb-4 mb-lg-0 ms-lg-6">

                    <div wire:ignore class="border rounded d-flex align-items-center choices-label h-50p">
                        <span class="ps-5" style="width: 115px">{{ __('transf.sort_by') }} :</span>
                        <select
                            class="form-select form-select-sm text-dark border-0 ps-3 flex-grow-1 shadow-none dropdown-menu-end"
                            aria-label="Small select example" wire:model="sortingBy">
                            <option value="default">{{ __('transf.sort_default') }}</option>
                            <option value="popularity"> {{ __('transf.sort_popularity') }} </option>
                            <option value="new-courses">{{ __('transf.sort_new_courses') }}</option>
                            <option value="low-high">{{ __('transf.sort_price_low_to_high') }}</option>
                            <option value="high-low">{{ __('transf.sort_price_high_to_low') }}</option>
                        </select>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- COURSE --}}
    <div class="container">


        <div class="row">


            <div class="col-xl-12">
                <!-- EVENTS -->
                <section class="pt-5 pb-9 py-md-7 bg-white">
                    <div class="container">
                        <div class="text-center mb-md-8 mb-5 text-capitalize">
                            <h1 class="mb-1">{{ __('transf.instructor_courses') }}</h1>
                            <p class="font-size-lg mb-0">{{ __('transf.edit_manage_your_courses_here') }}</p>
                        </div>

                        @foreach ($courses as $course)
                            <div class="mb-5">
                                <!-- Card -->
                                <div class="card border shadow p-3">
                                    <div class="row gx-0 align-items-center">
                                        <!-- Image -->
                                        @php
                                            $firstPhoto = $course->photos->first();
                                            if ($firstPhoto && $firstPhoto->file_name != null) {
                                                $course_img = asset('assets/courses/' . $firstPhoto->file_name);
                                                if (
                                                    !file_exists(
                                                        public_path('assets/courses/' . $firstPhoto->file_name),
                                                    )
                                                ) {
                                                    $course_img = asset('image/not_found/item_image_not_found.webp');
                                                }
                                            } else {
                                                $course_img = asset('image/not_found/item_image_not_found.webp');
                                            }
                                        @endphp
                                        <a href="{{ route('instructor.courses.edit', $course->id) }}"
                                            class="col-auto d-block">
                                            <img class="img-fluid shadow-light-lg w-90p h-90p h-md-120p w-md-120p o-f-c"
                                                src="{{ $course_img }}" alt="{{ $course->title }}">
                                        </a>

                                        <div
                                            class="col khaleel w-90p h-90p h-md-120p w-md-120p  d-flex justify-content-center align-items-center">
                                            <!-- Overlay -->
                                            <div class="overlay">
                                                <span>{{ __('transf.edit_manage_your_course') }}</span>
                                            </div>

                                            <!-- Body -->
                                            <div class="col">
                                                <div class="card-body py-0 px-md-6 px-3">
                                                    <a href="{{ route('instructor.courses.edit', $course->id) }}"
                                                        class="d-block me-xl-10">
                                                        <h5 class="line-clamp-2 mb-0">
                                                            {{ $course->title }}
                                                        </h5>
                                                        <p>
                                                            <small>{{ __('panel.course_status') }} :
                                                                {!! $course->statusWithLabel() !!}
                                                            </small>
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <a href="{{ route('instructor.courses.edit', $course->id) }}"
                                                    class="col-auto  d-lg-flex justify-content-center align-items-center text-dodger text-none pe-xl-5 fw-semi-bold">
                                                    <span class="d-inline-block " style="width:230px;">
                                                        {{ __('transf.complete_your_course') }}

                                                    </span>

                                                    <div class="progress " style="width: 80%">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $course->progress }}%;"
                                                            aria-valuenow="{{ $course->progress }}" aria-valuemin="0"
                                                            aria-valuemax="100">{{ $course->progress }}%
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach






                        <div class="text-center mt-8 d-none">
                            <a href="event-list.html" class="d-inline-flex align-items-center fw-medium">
                                {{ __('transf.browse_all') }}
                                <div class="ms-2 d-flex">
                                    <!-- Icon -->
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.7779 4.6098L3.32777 0.159755C3.22485 0.0567475 3.08745 0 2.94095 0C2.79445 0 2.65705 0.0567475 2.55412 0.159755L2.2264 0.487394C2.01315 0.700889 2.01315 1.04788 2.2264 1.26105L5.96328 4.99793L2.22225 8.73895C2.11933 8.84196 2.0625 8.97928 2.0625 9.1257C2.0625 9.27228 2.11933 9.4096 2.22225 9.51269L2.54998 9.84025C2.65298 9.94325 2.7903 10 2.9368 10C3.0833 10 3.2207 9.94325 3.32363 9.84025L7.7779 5.38614C7.88107 5.2828 7.93774 5.14484 7.93741 4.99817C7.93774 4.85094 7.88107 4.71305 7.7779 4.6098Z"
                                            fill="currentColor" />
                                    </svg>

                                </div>
                            </a>
                        </div>


                    </div>
                </section>
            </div>


        </div>


    </div>
</div>


<script>
    document.querySelectorAll('.khaleel').forEach(card => {
        card.addEventListener('click', () => {
            const url = card.querySelector('a').getAttribute('href');
            window.location.href = url;
        });
    });
</script>
