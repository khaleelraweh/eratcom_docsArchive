<?php

namespace App\Http\Livewire\Frontend\Courses;

use App\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddToWishlistComponent extends Component
{
    use LivewireAlert;

    public $courseId;

    public function addToWishList()
    {

        $course = Course::whereId($this->courseId)->firstOrFail();

        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($course) {
            return $cartItem->id === $course->id;
        });

        if ($duplicates->isNotEmpty()) {
            $this->alert('error', __('panel.f_m_item_already_exist_in_wishlist_cart'));
        } else {
            Cart::instance('wishlist')->add($course->id, $course->title, 1, $course->price)->associate(Course::class);
            $this->emit('updateWishlistCount');
            $this->alert('success', __('panel.f_m_item_add_to_wishlist_cart'));
        }
    }


    public function render()
    {
        return view('livewire.frontend.courses.add-to-wishlist-component');
    }
}
