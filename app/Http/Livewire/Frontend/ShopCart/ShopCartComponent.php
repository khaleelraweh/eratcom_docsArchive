<?php

namespace App\Http\Livewire\Frontend\ShopCart;

use App\Models\Coupon;
use App\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ShopCartComponent extends Component
{

    use LivewireAlert;

    protected $listeners = [
        'updateCartCount' => 'render'
    ];

    public $cartItems;
    public $wishlistItems;
    public $subTotal;
    public $total;
    public $coupon_code;


    public function render()
    {

        $this->cartItems = getNumbers()->get('cartItems');
        $this->wishlistItems = Cart::instance('wishlist')->content();

        $this->subTotal = currency_converter(getNumbers()->get('subtotal'));
        $this->total = currency_converter(getNumbers()->get('total'));

        return view('livewire.frontend.shop-cart.shop-cart-component', [
            'cartItems'             => $this->cartItems,
            'subTotal'         => $this->subTotal,
            'total'            => $this->total,
            'wishlistItems'         => $this->wishlistItems,
        ]);
    }

    public function removeFromCart($rowId)
    {

        $cart = Cart::content()->where('rowId', $rowId);
        if ($cart->isNotEmpty()) {
            Cart::remove($rowId);
        }
        // Cart::instance('default')->remove($rowId);
        $this->emit('updateCartCount');
        $this->alert('success', __('panel.f_m_item_removed_from_shop_cart'));
    }


    public function removeFromWishlist($rowId)
    {
        $wishlist = Cart::instance('wishlist')->content()->where('rowId', $rowId);
        if ($wishlist->isNotEmpty()) {
            Cart::instance('wishlist')->remove($rowId);
        }
        $this->emit('updateCartCount');
        $this->alert('success', __('panel.f_m_item_removed_from_wishlist_cart'));
    }

    public function moveToCart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rId) use ($rowId) {
            return $rId === $rowId;
        });

        if ($duplicates->isNotEmpty()) {

            Cart::instance('wishlist')->remove($rowId);
            $this->alert('error', __('panel.f_m_item_already_exist_in_shop_cart'));
        } else {
            Cart::instance('default')->add($item->id, $item->name, 1, $item->price)->associate(Course::class);
            Cart::instance('wishlist')->remove($rowId);
            $this->emit('updateCartCount');

            $this->alert('success', __('panel.f_m_item_add_to_shop_cart'));
        }
    }

    public function moveToWishlist($rowId)
    {
        $item = Cart::instance('default')->get($rowId);

        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rId) use ($rowId) {
            return $rId === $rowId;
        });

        if ($duplicates->isNotEmpty()) {

            Cart::instance('default')->remove($rowId);
            $this->alert('error', __('panel.f_m_item_already_exist_in_wishlist_cart'));
        } else {
            Cart::instance('wishlist')->add($item->id, $item->name, 1, $item->price)->associate(Course::class);
            Cart::instance('default')->remove($rowId);
            $this->emit('updateCartCount');

            $this->alert('success', __('panel.f_m_item_add_to_wishlist_cart'));
        }
    }

    public function applyDiscount()
    {

        //check if the getNumbers()->get('subtotal') > 0 means there are product in the cart
        if (getNumbers()->get('subtotal') > 0) {

            // Get coupon infrom from db using coupon_code came from view livewire /checkout-component.blade.php
            $coupon = Coupon::where('code->' . app()->getLocale(), $this->coupon_code)->whereStatus(true)->first();

            // if there is no coupon came from db equil by query above 
            if (!$coupon) {
                // give alert and make coupon_code as null for getting new coupon
                $this->coupon_code = '';
                $this->alert('error', __('transf.Coupon is invalid !'));
            } else {

                // if there is coupon in db then use discount function from model to get the discount to cart_subtotal 
                $couponValue = $coupon->discount(getNumbers()->get('total'));

                // if discount came right and bigger than zero then 
                if ($couponValue > 0) {

                    // make the session of coupon to use in general helper in getNumbers() function and view
                    session()->put('coupon', [
                        'code' => $coupon->code,
                        'value' => $coupon->value, // maybe is percentage or fixed
                        'discount' => $couponValue // get only discount in fixed came from discount function in the productCouponModel
                    ]);

                    $this->coupon_code = session()->get('coupon')['code'];
                    $this->emit('updateCart');

                    $this->alert('success', __('transf.coupon is applied successfully'));
                } else if ($couponValue == 0) { // means checkDate() says date is expired
                    $this->alert('error', __('transf.Course coupon is invalid or expired !'));
                } else { // means checkUsedTimes() in productCoupon model says we losed all try of coupon because we used it
                    $this->alert('error', __('transf.Course coupon is used more than its permition which !') . $coupon->use_times . ' time/s ');
                }
            }
        } else {
            $this->coupon_code = '';
            $this->alert('error', __('transf.No Courses available in your cart'));
        }
    }


    public function removeCoupon()
    {
        session()->remove('coupon'); // it will remove coupon session so it will remove discount from getNumbers() function in GeneralHelper.php
        $this->coupon_code = '';
        $this->emit('updateCart');
        $this->alert('success', __('transf.Coupon is removed'));
    }
}
