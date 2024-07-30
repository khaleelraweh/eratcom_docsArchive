<?php

namespace App\Http\Livewire\Frontend\Header;

use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CartCountsComponent extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'updateCartCount' => 'mount'
    ];


    public $cartCount;

    public function mount()
    {
        $this->cartCount = Cart::instance('default')->content()->count();
    }

    public function render()
    {
        return view('livewire.frontend.header.cart-counts-component');
    }
}
