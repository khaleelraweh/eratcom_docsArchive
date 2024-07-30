<div>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 mb-5 mb-xl-0">
                <!-- SIDEBAR FILTER -->
                <div class=" vertical-scroll" id="courseSidebar">
                    <div class="border rounded mb-6 @@widgetBG">
                        <!-- Heading -->
                        <div id="coursefilter1">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse1"
                                    aria-expanded="true" aria-controls="coursefiltercollapse1">
                                    Category
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
                            aria-labelledby="coursefilter1" data-bs-parent="#courseSidebar">
                            <ul class="list-unstyled list-group list-checkbox">

                                @foreach ($specializations_menu as $specialization)
                                    <li class="custom-control custom-checkbox">
                                        <input type="checkbox" wire:model="selectedSpecializations"
                                            value="{{ $specialization->slug }}" class="custom-control-input"
                                            id="{{ $specialization->slug }}">
                                        <label class="custom-control-label font-size-base"
                                            for="{{ $specialization->slug }}">{{ $specialization->name }}
                                            ({{ $specialization->users_count }})
                                        </label>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <div class="border rounded mb-6 @@widgetBG">
                        <!-- Heading -->
                        <div id="coursefilter2">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse2"
                                    aria-expanded="true" aria-controls="coursefiltercollapse2">
                                    Instructors
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
                            aria-labelledby="coursefilter2" data-bs-parent="#courseSidebar">
                            <!-- Search -->
                            <form class="mb-4" wire:submit.prevent="submitSearch">
                                <div class="input-group input-group-filter">
                                    <input wire:model="searchQuery"
                                        class="form-control form-control-sm border-end-0 shadow-none" type="search"
                                        placeholder="Search" aria-label="Search">
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
                                @foreach ($instructors_menu as $name => $count)
                                    <li class="custom-control custom-checkbox">
                                        <input wire:model="selectedNames" type="checkbox" value="{{ $name }}"
                                            class="custom-control-input" id="InstructorscustomCheck{{ $loop->index }}">
                                        <label class="custom-control-label font-size-base"
                                            for="InstructorscustomCheck{{ $loop->index }}">
                                            {{ $name }} ({{ $count }})</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- filter by rating  --}}
                    <div class="border rounded mb-6 @@widgetBG">
                        <!-- Heading -->
                        <div id="coursefilter5">
                            <h4 class="mb-0">
                                <button
                                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse5"
                                    aria-expanded="true" aria-controls="coursefiltercollapse5">
                                    Rating
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
                            aria-labelledby="coursefilter5" data-bs-parent="#courseSidebar">
                            <ul class="list-unstyled list-group list-checkbox">
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="4.5"
                                        class="custom-control-input" id="RatingcustomCheck1">
                                    <label class="custom-control-label font-size-base" for="RatingcustomCheck1">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:90%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>& up</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="3.5"
                                        class="custom-control-input" id="RatingcustomCheck2">
                                    <label class="custom-control-label font-size-base" for="RatingcustomCheck2">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:70%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>& up</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="2.5"
                                        class="custom-control-input" id="RatingcustomCheck3">
                                    <label class="custom-control-label font-size-base" for="RatingcustomCheck3">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:50%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>& up</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="2"
                                        class="custom-control-input" id="RatingcustomCheck4">
                                    <label class="custom-control-label font-size-base" for="RatingcustomCheck4">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:35%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>& up</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model="selectedRatings" value="1"
                                        class="custom-control-input" id="RatingcustomCheck5">
                                    <label class="custom-control-label font-size-base" for="RatingcustomCheck5">
                                        <span class="d-flex align-items-end">
                                            <span class="star-rating">
                                                <span class="rating" style="width:10%;"></span>
                                            </span>

                                            <span class="ms-3">
                                                <span>& up</span>
                                            </span>
                                        </span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- <a href="#" class="btn btn-primary btn-block mb-10">CLEAR FILTER </a> --}}
                    <a href="#" class="btn btn-primary btn-block mb-10" wire:click="resetFilters">
                        RESET FILTER
                    </a>

                </div>

            </div>

            <div class="col-xl-9">
                <div class="row row-cols-md-3 mb-6 mb-xl-3">
                    @foreach ($instructors as $instructor)
                        <div class="col-md pb-4 pb-md-7">
                            <div class="card border shadow p-2 lift">
                                <!-- Image -->
                                <div class="card-zoom position-relative">
                                    <div class="card-float card-hover right-0 left-0 bottom-0 mb-4">
                                        <ul class="nav mx-n4 justify-content-center">
                                            @if ($instructor->facebook)
                                                <li class="nav-item px-4">
                                                    <a href="{{ $instructor->facebook }}" class="d-block text-white">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($instructor->twitter)
                                                <li class="nav-item px-4">
                                                    <a href="{{ $instructor->twitter }}" class="d-block text-white">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($instructor->instagram)
                                                <li class="nav-item px-4">
                                                    <a href="{{ $instructor->instagram }}"
                                                        class="d-block text-white">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($instructor->linkedin)
                                                <li class="nav-item px-4">
                                                    <a href="{{ $instructor->linkedin }}" class="d-block text-white">
                                                        <i class="fab fa-linkedin-in"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    <a href="{{ route('frontend.instructors_single', $instructor->id) }}"
                                        class="card-img sk-thumbnail img-ratio-4 card-hover-overlay d-block">
                                        @php
                                            if ($instructor->user_image != null) {
                                                $instructor_img = asset(
                                                    'assets/instructors/' . $instructor->user_image,
                                                );

                                                if (
                                                    !file_exists(
                                                        public_path('assets/instructors/' . $instructor->user_image),
                                                    )
                                                ) {
                                                    $instructor_img = asset('image/not_found/avator2.webp');
                                                }
                                            } else {
                                                $instructor_img = asset('image/not_found/avator2.webp');
                                            }
                                        @endphp
                                        <img class="rounded shadow-light-lg img-fluid" src="{{ $instructor_img }}"
                                            alt="..."></a>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer px-3 pt-4 pb-1">
                                    <a href="{{ route('frontend.instructors_single', $instructor->id) }}"
                                        class="d-block">
                                        <h5 class="mb-0">{{ $instructor->first_name }} {{ $instructor->last_name }}
                                        </h5>
                                    </a>
                                    <span class="font-size-d-sm">
                                        @if (count($instructor->specializations) > 0)
                                            @foreach ($instructor->specializations->take(2) as $specialization)
                                                {{ $specialization->name }}

                                                @if (!$loop->last)
                                                    &
                                                @endif
                                            @endforeach
                                        @else
                                            specification did not set yet
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


                <!-- PAGINATION -->
                <nav class="mb-11" aria-label="Page navigationa">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>
