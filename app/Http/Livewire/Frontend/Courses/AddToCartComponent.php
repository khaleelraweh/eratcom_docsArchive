<?php

namespace App\Http\Livewire\Frontend\Courses;

use App\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddToCartComponent extends Component
{
    use LivewireAlert;

    public $courseId;

    protected $listeners = [
        'updateCartCount' => 'render'
    ];



    public function render()
    {
        return view('livewire.frontend.courses.add-to-cart-component');
    }

    public function addToCart()
    {
        $course = Course::whereId($this->courseId)->firstOrFail();

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($course) {
            return $cartItem->id === $course->id;
        });

        if ($duplicates->isNotEmpty()) {
            $this->alert('error', __('panel.f_m_item_already_exist_in_shop_cart'));
        } else {
            Cart::instance('default')->add($course->id, $course->title, 1, $course->price)->associate(Course::class);
            $this->emit('updateCartCount');
            $this->alert('success', __('panel.f_m_item_add_to_shop_cart'));
        }
    }

    public function BuyNow()
    {
        $course = Course::whereId($this->courseId)->firstOrFail();

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($course) {
            return $cartItem->id === $course->id;
        });

        if ($duplicates->isNotEmpty()) {
            redirect()->route("frontend.shop_checkout");
        } else {
            Cart::instance('default')->add($course->id, $course->title, 1, $course->price)->associate(Course::class);
            $this->emit('updateCartCount');
            redirect()->route("frontend.shop_checkout");
        }
    }
}
