    <section class="py-5 py-md-11">
        <div class="container">
            <div class="text-center mb-8">
                <h1 class="text-uppercase mb-1">{{ __('transf.txt_trending_categories') }}</h1>
                <p class="font-size-lg mb-0 text-capitalize">{{ __('transf.txt_trending_categories_desc') }}</p>
            </div>

            <div class="row row-cols-md-3 row-cols-xl-4 mb-4">

                @forelse ($course_categories->take($amount) as $course_category)
                    <div class="col-md mb-6">
                        <!-- Card -->
                        @php
                            if ($course_category->firstMedia?->file_name != null) {
                                $course_category_img = asset(
                                    'assets/course_categories/' . $course_category->firstMedia?->file_name,
                                );

                                if (
                                    !file_exists(
                                        public_path(
                                            'assets/course_categories/' . $course_category->firstMedia?->file_name,
                                        ),
                                    )
                                ) {
                                    $course_category_img = asset('image/not_found/item_image_not_found.webp');
                                }
                            } else {
                                $course_category_img = asset('image/not_found/item_image_not_found.webp');
                            }
                        @endphp

                        <a href="{{ route('frontend.courses', $course_category->slug) }}"
                            class="card card-hover-image px-md-5 py-md-5 px-4 py-8 text-center position-relative h-180p"
                            style="background-image: url({{ $course_category_img }})">
                            <div class="my-auto">
                                <!-- Image -->
                                <div class="text-white hover-image display-4">
                                    <i class="{!! $course_category->icon !!}"></i>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer p-0">
                                    <h5 class="mb-0 line-clamp-1 text-white">{{ $course_category->title }}</h5>
                                    {{-- <p class="mb-0 line-clamp-1 text-white">{!! $course_category->description !!}</p> --}}
                                    <p class="mb-0 line-clamp-1 text-white">{{ __('transf.more_than') }}
                                        {{ count($course_category->courses->where('section', 1)) }}
                                        {{ __('transf.courses') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                @endforelse

            </div>


            <div class="text-center">



                @if ($showMoreBtn)
                    <a wire:click="load_more" class="btn btn-outline-sienna btn-x-wide lift d-inline-block">
                        {{ __('transf.btn_load_more_course_categories') }}
                    </a>
                @endif

                @if ($showLessBtn)
                    <a wire:click="load_less" class="btn btn-outline-sienna btn-x-wide lift d-inline-block">
                        {{ __('transf.btn_load_less_course_categories') }}
                    </a>
                @endif


                <a href="{{ route('frontend.courses') }}"
                    class="btn btn-outline-sienna btn-x-wide lift d-inline-block">
                    {{ __('transf.btn_view_all_course_categories') }}
                </a>



            </div>
        </div>
    </section>
