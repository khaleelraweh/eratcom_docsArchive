<div>
    <div class="mb-4 mb-md-0 me-md-6 me-lg-4 me-xl-6">
        <h6 class="mb-0 text-white">{{ __('transf.review') }}</h6>
        <div class="d-lg-flex align-items-center">
            <div class="star-rating mb-2 mb-lg-0">
                <div class="rating" style="width:{{ scaleToPercentage($averageRating, 5) }}%;"></div>
            </div>

            <div class="font-size-sm ms-lg-3 text-white">
                <span>{{ round($averageRating, 2) }} ({{ count($reviews) }}+ reviews)</span>
            </div>
        </div>
    </div>
</div>
