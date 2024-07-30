<div>
    <div class="container pb-6 pb-xl-10">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main ">
                        <div class="page type-page status-publish hentry mb-6">
                            <!-- .entry-header -->
                            <div class="entry-content">
                                <div class="woocommerce">
                                    <form class="woocommerce-cart-form table-responsive" action="#" method="post">
                                        <table
                                            class="shop_table shop_table_responsive cart woocommerce-cart-form__contents shop-cart-check-table">
                                            <thead>
                                                <tr>
                                                    <th class="product-name">{{ __('transf.courses_in_cart') }}</th>
                                                    <th class="product-subtotal">&nbsp;</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($cartItems as $item)
                                                    <tr class="woocommerce-cart-form__cart-item cart_item">
                                                        <td class="product-name" data-title="Product">
                                                            <div class="d-flex ">
                                                                <div class="image-container">
                                                                    <a
                                                                        href="{{ route('frontend.course_single', $item->model->slug) }}">
                                                                        @php
                                                                            if (
                                                                                $item->model->photos->first() != null &&
                                                                                $item->model->photos->first()
                                                                                    ->file_name != null
                                                                            ) {
                                                                                $item_model_img = asset(
                                                                                    'assets/courses/' .
                                                                                        $item->model->photos->first()
                                                                                            ->file_name,
                                                                                );

                                                                                if (
                                                                                    !file_exists(
                                                                                        public_path(
                                                                                            'assets/courses/' .
                                                                                                $item->model->photos->first()
                                                                                                    ->file_name,
                                                                                        ),
                                                                                    )
                                                                                ) {
                                                                                    $item_model_img = asset(
                                                                                        'image/not_found/item_image_not_found.webp',
                                                                                    );
                                                                                }
                                                                            } else {
                                                                                $item_model_img = asset(
                                                                                    'image/not_found/item_image_not_found.webp',
                                                                                );
                                                                            }
                                                                        @endphp
                                                                        <img src="{{ $item_model_img }}"
                                                                            class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
                                                                            alt="{{ $item->model->title }}">
                                                                    </a>
                                                                </div>
                                                                <div class="ms-3 ms-md-6  course_detail"
                                                                    style="flex: 100%; justify-content: space-between">

                                                                    <div class="row align-items-end mb-4 mb-md-7">
                                                                        <div class="col-md mb-1 mb-md-0">
                                                                            <a
                                                                                href="{{ route('frontend.course_single', $item->model->slug) }}">
                                                                                {{ $item->model->title }}
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-md-auto action">
                                                                            <a href="#"
                                                                                wire:click.prevent="removeFromCart('{{ $item->rowId }}')"
                                                                                class="remove"
                                                                                aria-label="Remove this item">
                                                                                <i
                                                                                    class="far fa-trash-alt text-secondary font-size-sm"></i>
                                                                                {{ __('transf.remove') }}
                                                                            </a> <br>
                                                                            <a href="#"
                                                                                wire:click.prevent="moveToWishlist('{{ $item->rowId }}')"
                                                                                class="remove"
                                                                                aria-label="Remove this item">
                                                                                <i
                                                                                    class="fas fa-sort-amount-down text-secondary font-size-sm"></i>
                                                                                {{ __('transf.move_to_wishlist') }}
                                                                            </a>



                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td style="width: 25%;text-align: center; padding:1rem 0.5rem"
                                                            class="product-subtotal" data-title="Total">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <div class="font-size-sm">
                                                                    {{ $new_price = currency_converter($item->model->price - $item->model->offer_price) }}

                                                                    @if ($new_price != currency_converter($item->model->price))
                                                                        <br>
                                                                        <del class="ms-1">
                                                                            <small>
                                                                                {{ currency_converter($item->price) }}
                                                                            </small>
                                                                        </del>
                                                                    @endif
                                                                </div>
                                                            </span>
                                                        </td>


                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <!-- .entry-content -->
                        </div>

                        <div class="page type-page status-publish hentry">
                            <!-- .entry-header -->
                            <div class="entry-content">
                                <div class="woocommerce">
                                    <form class="woocommerce-cart-form table-responsive" action="#" method="post">
                                        <table
                                            class="shop_table shop_table_responsive cart woocommerce-cart-form__contents shop-cart-check-table">
                                            <thead>
                                                <tr>
                                                    <th class="product-name">{{ __('transf.courses_in_wishlist') }}
                                                    </th>
                                                    <th class="product-subtotal">&nbsp;</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($wishlistItems as $item)
                                                    <tr class="woocommerce-cart-form__cart-item cart_item">
                                                        <td class="product-name" data-title="Product">
                                                            <div class="d-flex ">
                                                                <div class="image-container">
                                                                    <a
                                                                        href="{{ route('frontend.course_single', $item->model->slug) }}">
                                                                        @php
                                                                            if (
                                                                                $item->model->photos->first() != null &&
                                                                                $item->model->photos->first()
                                                                                    ->file_name != null
                                                                            ) {
                                                                                $item_model_img = asset(
                                                                                    'assets/courses/' .
                                                                                        $item->model->photos->first()
                                                                                            ->file_name,
                                                                                );

                                                                                if (
                                                                                    !file_exists(
                                                                                        public_path(
                                                                                            'assets/courses/' .
                                                                                                $item->model->photos->first()
                                                                                                    ->file_name,
                                                                                        ),
                                                                                    )
                                                                                ) {
                                                                                    $item_model_img = asset(
                                                                                        'image/not_found/item_image_not_found.webp',
                                                                                    );
                                                                                }
                                                                            } else {
                                                                                $item_model_img = asset(
                                                                                    'image/not_found/item_image_not_found.webp',
                                                                                );
                                                                            }
                                                                        @endphp
                                                                        <img src="{{ $item_model_img }}"
                                                                            class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
                                                                            alt="{{ $item->model->title }}">
                                                                    </a>
                                                                </div>
                                                                <div class="ms-3 ms-md-6 course_detail"
                                                                    style="flex: 100%; justify-content: space-between">

                                                                    <div class="row align-items-end mb-4 mb-md-7">
                                                                        <div class="col-md mb-1 mb-md-0">
                                                                            <a
                                                                                href="{{ route('frontend.course_single', $item->model->slug) }}">
                                                                                {{ $item->model->title }}
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-md-auto action">
                                                                            <a href="#"
                                                                                wire:click.prevent="removeFromWishlist('{{ $item->rowId }}')"
                                                                                class="remove"
                                                                                aria-label="Remove this item">
                                                                                <i
                                                                                    class="far fa-trash-alt text-secondary font-size-sm"></i>
                                                                                {{ __('transf.remove') }}
                                                                            </a> <br>
                                                                            <a href="#"
                                                                                wire:click.prevent="moveToCart('{{ $item->rowId }}')"
                                                                                class="remove"
                                                                                aria-label="Remove this item">
                                                                                <i
                                                                                    class="fas fa-sort-amount-up text-secondary font-size-sm"></i>
                                                                                {{ __('transf.move_to_cart') }}
                                                                            </a>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td style="width: 25%;text-align: center; padding:1rem 0.5rem"
                                                            class="product-subtotal" data-title="Total">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <div class="font-size-sm">
                                                                    {{ $new_price = currency_converter($item->model->price - $item->model->offer_price) }}

                                                                    @if ($new_price != currency_converter($item->model->price))
                                                                        <br>
                                                                        <del class="ms-1">
                                                                            <small>
                                                                                {{ currency_converter($item->price) }}
                                                                            </small>
                                                                        </del>
                                                                    @endif
                                                                </div>
                                                            </span>
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <!-- .entry-content -->
                        </div>
                    </main>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div id="secondary" class="sidebar" role="complementary">
                    <div class="cart-collaterals">
                        <div class="cart_totals">
                            <h2>{{ __('transf.txt_order_subtotal') }}</h2>

                            <table class="shop_table shop_table_responsive">
                                <tbody>
                                    <tr class="cart-subtotal ">
                                        <th>{{ __('transf.subtotal') }}</th>
                                        <td data-title="Subtotal">
                                            <span class="woocommerce-Price-amount amount">{{ $total }}
                                                @if ($total != $subTotal)
                                                    <del class="ms-1">
                                                        <small>
                                                            {{ $subTotal }}
                                                        </small>
                                                    </del>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>



                                    <tr class="order-total ">
                                        <th>{{ __('transf.total') }}</th>
                                        <td data-title="Total"><strong><span
                                                    class="woocommerce-Price-amount amount">{{ $total }}</span></strong>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                            <div class="wc-proceed-to-checkout">
                                <a href="{{ route('frontend.shop_checkout') }}"
                                    class="checkout-button button alt wc-forward">
                                    {{-- Proceed to checkout --}}
                                    {{ __('transf.checkout') }}
                                </a>
                            </div>

                            <hr class="mb-2">
                            <h6 class="mt-0">{{ __('transf.promotions') }}</h6>
                            <div class="">
                                <form wire:submit.prevent="applyDiscount()">
                                    <div class="input-group">
                                        @if (!session()->has('coupon'))
                                            <input type="text" wire:model="coupon_code" name="coupon_code"
                                                class="form-control" placeholder="{{ __('transf.enter_coupon') }}"
                                                aria-label="Enter Coupon" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary " type="button"
                                                    id="button-addon2">{{ __('transf.apply') }}</button>
                                            </div>
                                        @else
                                            <div class="wc-proceed-to-checkout">
                                                <a href="#" wire:click.prevent="removeCoupon()"
                                                    class="checkout-button button alt wc-forward">
                                                    {{ __('transf.remove_coupon') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
