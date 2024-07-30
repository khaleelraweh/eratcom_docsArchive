<?php

namespace App\Http\Livewire\Frontend\Modals;

use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CartModalComponent extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'updateCartCount' => 'render'
    ];

    public $cartItems;
    public $subTotal;
    public $total;

    public function render()
    {
        $this->cartItems = getNumbers()->get('cartItems');
        $this->subTotal = currency_converter(getNumbers()->get('subtotal'));
        $this->total = currency_converter(getNumbers()->get('total'));

        return view('livewire.frontend.modals.cart-modal-component', [
            'cartItems'             => $this->cartItems,
            'total'            =>  $this->total,
            'subTotal'         =>  $this->subTotal
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
}
