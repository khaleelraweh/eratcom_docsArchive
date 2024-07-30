<div>
    {{-- Items --}}
    {{-- {{ $cartItems }} --}}
    <ul class="list-group list-group-flush mb-5">
        @foreach ($cartItems as $item)
            <li class="list-group-item border-bottom py-0">
                <div class="d-flex py-5">
                    <div class="bg-gray-200 w-60p h-60p rounded-circle overflow-hidden">
                        @php
                            if (
                                $item->model->photos->first() != null &&
                                $item->model->photos->first()->file_name != null
                            ) {
                                $item_model_img = asset('assets/courses/' . $item->model->photos->first()->file_name);

                                if (
                                    !file_exists(
                                        public_path('assets/courses/' . $item->model->photos->first()->file_name),
                                    )
                                ) {
                                    $item_model_img = asset('image/not_found/item_image_not_found.webp');
                                }
                            } else {
                                $item_model_img = asset('image/not_found/item_image_not_found.webp');
                            }
                        @endphp
                        <img class="bg-gray-200 w-60p h-60p rounded-circle overflow-hidden" src="{{ $item_model_img }}"
                            alt="{{ $item->model->title }}">
                    </div>

                    <div class="flex-grow-1 mt-1 ms-4">
                        <h6 class="fw-normal mb-0">{{ $item->model->title }}</h6>
                        <div class="font-size-sm">
                            {{ $new_price = currency_converter($item->model->price - $item->model->offer_price) }}

                            @if ($new_price != currency_converter($item->model->price))
                                <del class="ms-1"><small>{{ currency_converter($item->price) }}</small></del>
                            @endif
                        </div>
                    </div>

                    <a href="#" wire:click.prevent="removeFromCart('{{ $item->rowId }}')"
                        class="d-inline-flex text-secondary">
                        <!-- Icon -->
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.0469 0H5.95294C5.37707 0 4.90857 0.4685 4.90857 1.04437V3.02872H6.16182V1.25325H9.83806V3.02872H11.0913V1.04437C11.0913 0.4685 10.6228 0 10.0469 0Z"
                                fill="currentColor" />
                            <path d="M11.0492 5.51652L9.7968 5.47058L9.52527 12.8857L10.7777 12.9315L11.0492 5.51652Z"
                                fill="currentColor" />
                            <path d="M8.62666 5.49353H7.37341V12.9087H8.62666V5.49353Z" fill="currentColor" />
                            <path d="M6.47453 12.8855L6.203 5.47034L4.95056 5.51631L5.22212 12.9314L6.47453 12.8855Z"
                                fill="currentColor" />
                            <path
                                d="M0.543091 2.4021V3.65535H1.849L2.885 15.4283C2.9134 15.7519 3.18434 16 3.50912 16H12.4697C12.7946 16 13.0657 15.7517 13.0939 15.4281L14.1299 3.65535H15.4569V2.4021H0.543091ZM11.8958 14.7468H4.08293L3.10706 3.65535H12.8719L11.8958 14.7468Z"
                                fill="currentColor" />
                        </svg>

                    </a>
                </div>
            </li>
        @endforeach

    </ul>

    {{-- Total --}}
    <div class="d-flex mb-5">
        <h5 class="mb-0 me-auto">{{ __('transf.txt_order_subtotal') }}</h5>
        <h5 class="mb-0">
            {{ $total }}

            @if ($total != $subTotal)
                <del class="ms-1">
                    <small>
                        {{ $subTotal }}
                    </small>
                </del>
            @endif

        </h5>
    </div>
</div>
