<div>
    {{-- CONTROL BAR --}}
    <div class="container mb-6 mb-xl-8 z-index-2">
        <div class="d-lg-flex align-items-center mb-6 mb-xl-0">

            <p class="mb-lg-0">{{ __('transf.txt_we_found') }} <span class="text-dark">{{ $courses->total() }}
                    {{ __('transf.courses') }}</span> {{ __('transf.txt_available_for_you') }}
            </p>
            <div class="ms-lg-auto d-lg-flex flex-wrap">
                <div class="mb-4 mb-lg-0 ms-lg-6">

                    <div wire:ignore class="border rounded d-flex align-items-center choices-label h-50p">
                        <span class="ps-5" style="width: 110px">{{ __('transf.sort_by') }}:</span>
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
            <div class="col-xl-3 mb-5 mb-xl-0">
                {{-- SIDEBAR FILTER --}}
                <div class=" vertical-scroll" id="courseSidebar">
                    <div class="border rounded mb-6 bg-white">
                        <!-- Heading -->
                        <div id="coursefilter1">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse1"
                                    aria-expanded="true" aria-controls="coursefiltercollapse1">
                                    {{ __('transf.categories') }}
                                    <span class="ms-auto text-dark d-flex">
                                        <!-- Icon -->
                                        <svg width="15" height="2" viewBox="0 0 15 2" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="15" height="2" fill="currentColor" />
                                        </svg>

                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 7H15V9H0V7Z" fill="currentColor" />
                                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor" />
                                        </svg>

                                    </span>
                                </button>
                            </h4>
                        </div>


                        <div id="coursefiltercollapse1" class="collapse show mt-n2 px-6 pb-6"
                            aria-labelledby="coursefilter1" data-parent="#courseSidebar">
                            <ul class="list-unstyled list-group list-checkbox">
                                @foreach ($course_categories_menu as $category_item)
                                    <li class="custom-control custom-checkbox">

                                        <input type="checkbox" wire:model="categoryInputs"
                                            value="{{ $category_item->slug }}" class="custom-control-input"
                                            id="{{ $category_item->slug }}">

                                        <label class="custom-control-label font-size-base"
                                            for="{{ $category_item->slug }}">{{ $category_item->title }}
                                            ({{ $category_item->courses_count }})
                                        </label>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <div class="border rounded mb-6 bg-white ">
                        <!-- Heading -->
                        <div id="coursefilter2">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse2"
                                    aria-expanded="true" aria-controls="coursefiltercollapse2">
                                    {{ __('transf.instructors') }}
                                    <span class="ms-auto text-dark d-flex">
                                        <!-- Icon -->
                                        <svg width="15" height="2" viewBox="0 0 15 2" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="15" height="2" fill="currentColor" />
                                        </svg>

                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 7H15V9H0V7Z" fill="currentColor" />
                                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor" />
                                        </svg>

                                    </span>
                                </button>
                            </h4>
                        </div>

                        <div id="coursefiltercollapse2" class="collapse show mt-n2 px-6 pb-6"
                            aria-labelledby="coursefilter2" data-parent="#courseSidebar">
                            <!-- Search -->
                            <form class="mb-4" wire:submit.prevent="submitSearch">
                                <div class="input-group input-group-filter">
                                    <input wire:model="searchQuery"
                                        class="form-control form-control-sm border-end-0 shadow-none" type="search"
                                        placeholder="{{ __('transf.search') }}" aria-label="Search">
                                    <div class="input-group-append">
                                        <button
                                            class="btn btn-sm btn-outline-white border-start-0 shadow-none bg-transparent text-secondary icon-xs d-flex align-items-center"
                                            type="submit">
                                            <!-- Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.8477 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.8477 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.8477 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M19.762 18.6121L15.1007 13.9509C14.7831 13.6332 14.2687 13.6332 13.9511 13.9509C13.6335 14.2682 13.6335 14.7831 13.9511 15.1005L18.6124 19.7617C18.7712 19.9205 18.9791 19.9999 19.1872 19.9999C19.395 19.9999 19.6032 19.9205 19.762 19.7617C20.0796 19.4444 20.0796 18.9295 19.762 18.6121Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            {{-- instructors filter by name  --}}
                            <ul class="list-unstyled list-group list-checkbox list-checkbox-limit">
                                @foreach ($instructors_menu as $name => $counts)
                                    <li class="custom-control custom-checkbox">
                                        <input wire:model="selectedNames" type="checkbox"
                                            value="{{ $name }}" class="custom-control-input"
                                            id="InstructorscustomCheck{{ $loop->index }}">
                                        <label class="custom-control-label font-size-base"
                                            for="InstructorscustomCheck{{ $loop->index }}">
                                            {{ $name }}
                                            {{-- ({{ $counts['instructorsCount'] }}) --}}
                                            ({{ $counts['coursesCount'] }})
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="border rounded mb-6 bg-white">
                        <!-- Heading -->
                        <div id="coursefilter3">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse3"
                                    aria-expanded="true" aria-controls="coursefiltercollapse3">
                                    {{ __('transf.prices') }}
                                    <span class="ms-auto text-dark d-flex">
                                        <!-- Icon -->
                                        <svg width="15" height="2" viewBox="0 0 15 2" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="15" height="2" fill="currentColor" />
                                        </svg>

                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 7H15V9H0V7Z" fill="currentColor" />
                                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor" />
                                        </svg>

                                    </span>
                                </button>
                            </h4>
                        </div>

                        <div id="coursefiltercollapse3" class="collapse show mt-n2 px-6 pb-6"
                            aria-labelledby="coursefilter3" data-parent="#courseSidebar">
                            <ul class="list-unstyled list-group list-checkbox">

                                <li class="custom-control custom-radio">

                                    <input type="radio" wire:model="priceInput" id="pricecustomradio1"
                                        name="customRadio" value="all" class="custom-control-input">

                                    <label class="custom-control-label font-size-base"
                                        for="pricecustomradio1">{{ __('transf.all') }}
                                        ({{ count($courses) ?? 0 }})
                                    </label>
                                </li>
                                <li class="custom-control custom-radio">
                                    <input type="radio" wire:model="priceInput" id="pricecustomradio2"
                                        name="customRadio" value="free" class="custom-control-input">
                                    <label class="custom-control-label font-size-base"
                                        for="pricecustomradio2">{{ __('transf.free') }}
                                        ({{ count($courses->where('price', '=', 0)) ?? 0 }})
                                    </label>
                                </li>
                                <li class="custom-control custom-radio">
                                    <input type="radio" wire:model="priceInput" id="pricecustomradio3"
                                        name="customRadio" value="paid" class="custom-control-input">
                                    <label class="custom-control-label font-size-base"
                                        for="pricecustomradio3">{{ __('transf.paid') }}
                                        ({{ count($courses->where('price', '>', 0)) ?? 0 }})
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="border rounded mb-6 bg-white">
                        <!-- Heading -->
                        <div id="coursefilter4">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse4"
                                    aria-expanded="true" aria-controls="coursefiltercollapse4">
                                    {{ __('transf.levels') }}
                                    <span class="ms-auto text-dark d-flex">
                                        <!-- Icon -->
                                        <svg width="15" height="2" viewBox="0 0 15 2" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="15" height="2" fill="currentColor" />
                                        </svg>

                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 7H15V9H0V7Z" fill="currentColor" />
                                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor" />
                                        </svg>

                                    </span>
                                </button>
                            </h4>
                        </div>

                        <div id="coursefiltercollapse4" class="collapse show mt-n2 px-6 pb-6"
                            aria-labelledby="coursefilter4" data-parent="#courseSidebar">
                            <ul class="list-unstyled list-group list-checkbox">
                                <li class="custom-control custom-checkbox">

                                    <input type="checkbox" wire:model="courseLevels" value="1"
                                        class="custom-control-input" id="levelcustomcheck1">

                                    <label class="custom-control-label font-size-base"
                                        for="levelcustomcheck1">{{ __('transf.beginner') }}
                                        ({{ count($courses->where('skill_level', 1)) ?? 0 }})
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">

                                    <input type="checkbox" wire:model="courseLevels" value="2"
                                        class="custom-control-input" id="levelcustomcheck2">

                                    <label class="custom-control-label font-size-base" for="levelcustomcheck2">
                                        {{ __('transf.intermediate') }}
                                        ({{ count($courses->where('skill_level', 2)) ?? 0 }})
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">

                                    <input type="checkbox" wire:model="courseLevels" value="3"
                                        class="custom-control-input" id="levelcustomcheck3">

                                    <label class="custom-control-label font-size-base" for="levelcustomcheck3">
                                        {{ __('transf.advance') }}
                                        ({{ count($courses->where('skill_level', 3)) ?? 0 }})
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- filter by rating  --}}
                    <div class="border rounded mb-6 bg-white ">
                        <!-- Heading -->
                        <div id="coursefilter5">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse5"
                                    aria-expanded="true" aria-controls="coursefiltercollapse5">
                                    {{ __('transf.ratings') }}
                                    <span class="ms-auto text-dark d-flex">
                                        <!-- Icon -->
                                        <svg width="15" height="2" viewBox="0 0 15 2" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="15" height="2" fill="currentColor" />
                                        </svg>

                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 7H15V9H0V7Z" fill="currentColor" />
                                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor" />
                                        </svg>

                                    </span>
                                </button>
                            </h4>
                        </div>

                        <div id="coursefiltercollapse5" class="collapse show mt-n2 px-6 pb-6"
                            aria-labelledby="coursefilter5" data-parent="#courseSidebar">
                            <ul class="list-unstyled list-group list-checkbox">
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="4.5"
                                        class="custom-control-input" id="ratingcustomcheck1">
                                    <label class="custom-control-label font-size-base" for="ratingcustomcheck1">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:90%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>{{ __('transf.&_up') }}</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="3.5"
                                        class="custom-control-input" id="ratingcustomcheck2">
                                    <label class="custom-control-label font-size-base" for="ratingcustomcheck2">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:70%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>{{ __('transf.&_up') }}</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="2.5"
                                        class="custom-control-input" id="ratingcustomcheck3">
                                    <label class="custom-control-label font-size-base" for="ratingcustomcheck3">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:50%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>{{ __('transf.&_up') }}</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="2"
                                        class="custom-control-input" id="ratingcustomcheck4">
                                    <label class="custom-control-label font-size-base" for="ratingcustomcheck4">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:35%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>{{ __('transf.&_up') }}</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="1"
                                        class="custom-control-input" id="ratingcustomcheck5">
                                    <label class="custom-control-label font-size-base" for="ratingcustomcheck5">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:10%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>{{ __('transf.&_up') }}</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>




                    {{-- <a href="#" class="btn btn-primary btn-block mb-10">CLEAR FILTER </a> --}}
                    <a href="#" class="btn btn-primary btn-block mb-10" wire:click="resetFilters">
                        {{ __('transf.reset_filter') }}
                    </a>
                </div>

            </div>

            <div class="col-xl-9">
                <div class="row row-cols-md-2 row-cols-lg-3 mb-3 ">
                    @foreach ($courses as $course)
                        <div class="col-md pb-4 pb-md-7">
                            <!-- Card -->
                            <div class="card border shadow p-2 lift sk-fade">
                                <!-- Image -->

                                @php
                                    if (
                                        $course->photos->first() != null &&
                                        $course->photos->first()->file_name != null
                                    ) {
                                        $course_img = asset('assets/courses/' . $course->photos->first()->file_name);

                                        if (
                                            !file_exists(
                                                public_path('assets/courses/' . $course->photos->first()->file_name),
                                            )
                                        ) {
                                            $course_img = asset('image/not_found/item_image_not_found.webp');
                                        }
                                    } else {
                                        $course_img = asset('image/not_found/item_image_not_found.webp');
                                    }
                                @endphp
                                <div class="card-zoom position-relative">
                                    <a href="{{ route('customer.lesson_single', $course->slug) }}"
                                        class="card-img sk-thumbnail img-ratio-3 d-block">
                                        <img class="rounded shadow-light-lg" src="{{ $course_img }}"
                                            alt="...">
                                    </a>

                                    <span class="sk-fade-right badge-float bottom-0 right-0 mb-2 me-2">
                                        @if ($course->offer_price > 0)
                                            @if ($course->offer_price == $course->price)
                                                <del class="font-size-sm bg-success text-dark p-1 rounded-pill">
                                                    {{ currency_converter($course->price) }}
                                                </del>
                                                <ins class="h4 mb-0 d-block mb-lg-n1">
                                                    {{ __('transf.free') }}
                                                </ins>
                                            @else
                                                <del class="font-size-sm bg-success text-dark p-1 rounded-pill">
                                                    {{ currency_converter($course->price) }}
                                                </del>
                                                <ins class="h4 mb-0 d-block mb-lg-n1">
                                                    {{ currency_converter($course->price - $course->offer_price) }}
                                                </ins>
                                            @endif
                                        @else
                                            <ins class="h4 mb-0 d-block mb-lg-n1">
                                                @if ($course->price == 0)
                                                    {{ __('transf.free') }}
                                                @else
                                                    {{ currency_converter($course->price) }}
                                                @endif
                                            </ins>
                                        @endif
                                    </span>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer px-2 pb-2 mb-1 pt-4 position-relative">
                                    <!-- Preheading -->
                                    <a href="{{ route('frontend.courses', $course->courseCategory->slug) }}"><span
                                            class="mb-1 d-inline-block text-gray-800">{{ $course->courseCategory->title }}
                                        </span></a>

                                    <!-- Heading -->
                                    <div class="position-relative">
                                        <a href="{{ route('customer.lesson_single', $course->slug) }}"
                                            class="d-block stretched-link">
                                            <h5 class="line-clamp-2 h-md-48 h-lg-58 me-md-8 me-lg-10 me-xl-4 mb-2">
                                                {{ $course->title }}
                                            </h5>
                                        </a>

                                        <div class="row mx-n2 align-items-end">
                                            <div class="col px-2">
                                                <ul class="nav mx-n3">
                                                    <li class="nav-item px-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2 d-flex text-secondary icon-uxs">
                                                                <!-- Icon -->
                                                                <svg width="20" height="20"
                                                                    viewBox="0 0 20 20" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M17.1947 7.06802L14.6315 7.9985C14.2476 7.31186 13.712 6.71921 13.0544 6.25992C12.8525 6.11877 12.6421 5.99365 12.4252 5.88303C13.0586 5.25955 13.452 4.39255 13.452 3.43521C13.452 1.54098 11.9124 -1.90735e-06 10.0197 -1.90735e-06C8.12714 -1.90735e-06 6.58738 1.54098 6.58738 3.43521C6.58738 4.39255 6.98075 5.25955 7.61414 5.88303C7.39731 5.99365 7.1869 6.11877 6.98502 6.25992C6.32752 6.71921 5.79178 7.31186 5.40787 7.9985L2.8447 7.06802C2.33612 6.88339 1.79688 7.26044 1.79688 7.80243V16.5178C1.79688 16.8465 2.00256 17.14 2.31155 17.2522L9.75312 19.9536C9.93073 20.018 10.1227 20.0128 10.2863 19.9536L17.7278 17.2522C18.0368 17.14 18.2425 16.8465 18.2425 16.5178V7.80243C18.2425 7.26135 17.704 6.88309 17.1947 7.06802ZM10.0197 1.5625C11.0507 1.5625 11.8895 2.40265 11.8895 3.43521C11.8895 4.46777 11.0507 5.30792 10.0197 5.30792C8.98866 5.30792 8.14988 4.46777 8.14988 3.43521C8.14988 2.40265 8.98866 1.5625 10.0197 1.5625ZM9.23844 18.1044L3.35938 15.9703V8.91724L9.23844 11.0513V18.1044ZM10.0197 9.67255L6.90644 8.54248C7.58164 7.51892 8.75184 6.87042 10.0197 6.87042C11.2875 6.87042 12.4577 7.51892 13.1329 8.54248L10.0197 9.67255ZM16.68 15.9703L10.8009 18.1044V11.0513L16.68 8.91724V15.9703Z"
                                                                        fill="currentColor" />
                                                                </svg>

                                                            </div>
                                                            <div class="font-size-sm">
                                                                {{ $course->totalLessonsCount() }}

                                                                {{ __('transf.lessons') }}
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-auto px-2 text-right">
                                                <div class="star-rating mb-2 mb-lg-0">
                                                    <div class="rating"
                                                        style="width:{{ scaleToPercentage($course->reviews->pluck('rating')->avg(), 5) }}%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach




                </div>

                {{-- PAGINATION --}}
                <nav class="mb-11" aria-label="Page navigationa">
                    <ul class="pagination justify-content-center">
                        {!! $courses->appends(request()->all())->onEachSide(3)->links() !!}
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>
