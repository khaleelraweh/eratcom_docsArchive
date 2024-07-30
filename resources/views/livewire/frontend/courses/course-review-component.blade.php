<div>


    {{-- show course rating  --}}
    <div class="row align-items-center mb-8">
        <div class="col-md-auto mb-5 mb-md-0">
            <div class="border rounded shadow d-flex align-items-center justify-content-center px-9 py-8">
                <div class="m-2 text-center">
                    <h1 class="display-2 mb-0 fw-medium mb-n1">{{ round($averageRating, 2) }}</h1>
                    <h5 class="mb-0">{{ __('transf.txt_course_rating') }}</h5>
                    <div class="star-rating">
                        <div class="rating" style="width:{{ scaleToPercentage(round($averageRating, 2), 5) }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md">
            @php
                $totalReviews = $totalReviews ?? 0;
                krsort($ratingCounts);
            @endphp
            @foreach ($ratingCounts as $rating => $count)
                <div class="d-md-flex align-items-center my-3 my-md-4">
                    <div class="bg-gray-200 position-relative rounded-pill flex-grow-1 me-md-5 mb-2 mb-md-0 mw-md-260p"
                        style="height: 10px;">
                        <div class="bg-teal rounded-pill position-absolute top-0 left-0 bottom-0" {{-- style="width: {{ $count ? ($count / $totalReviews) * 100 : 0 }}%;"></div> --}}
                            style="width: {{ scaleToPercentage($rating, 5) }}%;"></div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="star-rating star-rating-lg secondary me-4">
                            <div class="rating" style="width: {{ scaleToPercentage($rating, 5) }}%;">
                            </div>
                        </div>
                        <span>{{ $count }}</span>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

    {{-- show reviews --}}
    <h3 class="mb-6">{{ __('transf.txt_comments') }}</h3>
    <ul class="list-unstyled pt-2">
        @foreach ($reviews as $review)
            <li class="media d-flex">
                <div class="avatar avatar-xxl me-3 me-md-6 flex-shrink-0">
                    @php
                        if ($review->user->user_image != null) {
                            $review_user_image = asset('assets/customers/' . $review->user->user_image);

                            if (!file_exists(public_path('assets/customers/' . $review->user->user_image))) {
                                $review_user_image = asset('image/not_found/avator1.webp');
                            }
                        } else {
                            $review_user_image = asset('image/not_found/avator1.webp');
                        }
                    @endphp

                    <img src="{{ $review_user_image }}" alt="..." class="avatar-img rounded-circle">
                </div>

                <div class="media-body flex-grow-1">
                    <div class="d-md-flex align-items-center mb-5">
                        <div class="me-auto mb-4 mb-md-0">
                            <h5 class="mb-0">{{ $review->user->full_name }}</h5>
                            <p class="font-size-sm font-italic">{{ $review->title }}</p>
                        </div>
                        <div class="star-rating">
                            {{-- <div class="rating" style="width:100%;"></div> --}}
                            <div class="rating" style="width:{{ scaleToPercentage($review->rating, 5) }}%;"></div>
                        </div>
                    </div>
                    <p class="mb-6 line-height-md">
                        {{ $review->message }}
                    </p>
                </div>
            </li>
        @endforeach


    </ul>

    {{-- add reviews and rating --}}
    <div class="border shadow rounded p-6 p-md-9">
        <h3 class="mb-2">{{ __('transf.txt_add_reviews_rate') }}</h3>
        <div class="">{{ __('transf.txt_what_is_it_like_to_course') }}</div>
        <form wire:submit.prevent="storeReview">
            <div class="clearfix">
                <fieldset class="slect-rating mb-3">

                    <input wire:model.defer="rating" type="radio" id="star5" name="rating" value="5" />
                    <label class="full" for="star5" title="{{ __('Awesome - 5 stars') }}"></label>

                    <input wire:model.defer="rating" type="radio" id="star4half" name="rating" value="4.5" />
                    <label class="half" for="star4half" title="{{ __('Pretty good - 4.5 stars') }}"></label>

                    <input wire:model.defer="rating" type="radio" id="star4" name="rating" value="4" />
                    <label class="full" for="star4" title="{{ __('Pretty good - 5 stars') }}"></label>

                    <input wire:model.defer="rating" type="radio" id="star3half" name="rating" value="3.5" />
                    <label class="half" for="star3half" title="{{ __('Meh - 3.5 stars') }} "></label>

                    <input wire:model.defer="rating" type="radio" id="star3" name="rating" value="3" />
                    <label class="full" for="star3" title="{{ __('Meh - 3 stars') }}"></label>

                    <input wire:model.defer="rating" type="radio" id="star2half" name="rating" value="2.5" />
                    <label class="half" for="star2half" title="{{ __('Kinda bad - 2.5 stars') }}"></label>

                    <input wire:model.defer="rating" type="radio" id="star2" name="rating" value="2" />
                    <label class="full" for="star2" title="{{ __('Kinda bad - 2 stars') }}"></label>

                    <input wire:model.defer="rating" type="radio" id="star1half" name="rating" value="1.5" />
                    <label class="half" for="star1half" title="{{ __('Meh - 1.5 stars') }}"></label>

                    <input wire:model.defer="rating" type="radio" id="star1" name="rating" value="1" />
                    <label class="full" for="star1" title="{{ __('Sucks big time - 1 star') }}"></label>

                    <input type="radio" id="starhalf" name="rating" value="0.5" />
                    <label class="half" for="starhalf" title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                </fieldset>
            </div>


            <div class="form-group mb-6">
                <!-- Title input -->
                <label for="exampleInputTitle1">{{ __('transf.txt_review_title') }}</label>
                <input wire:model.defer="title" type="text" name="title" class="form-control placeholder-1"
                    id="exampleInputTitle1" placeholder="{{ __('transf.txt_courses') }}">
                @error('title')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-6">
                <!-- Review message input -->
                <label for="exampleFormControlTextarea1">{{ __('transf.txt_review_content') }}</label>
                <textarea wire:model.defer="message" name="message" class="form-control placeholder-1"
                    id="exampleFormControlTextarea1" rows="6" placeholder="{{ __('transf.txt_content') }}"></textarea>
                @error('message')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>


            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mw-md-300p">
                {{ __('transf.txt_submit_review') }}
            </button>



            {{-- message if reviewer try to make review without login --}}
            @if (session('review_error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('review_error') }}
                </div>
            @endif

        </form>
    </div>
</div>
