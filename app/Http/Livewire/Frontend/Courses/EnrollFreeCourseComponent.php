<?php

namespace App\Http\Livewire\Frontend\Courses;

use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\Order;
use App\Models\OrderTransaction;
use Livewire\Component;
use Illuminate\Support\Str;

class EnrollFreeCourseComponent extends Component
{

    public $courseId;


    public $payment_method = 3; //mean free

    public function render()
    {
        return view('livewire.frontend.courses.enroll-free-course-component');
    }

    public function enrollCourse()
    {
        $course = Course::whereId($this->courseId)->firstOrFail();
        $ref_id = 'ORD-' . Str::random(15);

        //make free order to free course
        $order = Order::create([
            'ref_id'                => $ref_id,
            'user_id'               => auth()->id(),
            'payment_method_id'     => $this->payment_method,
            'subtotal'              => 0,
            'offer_discount'        => 0,
            'discount_code'         =>  null,
            'discount'              => getNumbers()->get('discount_coupon'),
            'shipping'              => getNumbers()->get('shipping'),
            'tax'                   => getNumbers()->get('courseTaxes'),
            'total'                 => 0,
            'currency'              => 'USD',
            'order_status'          => 0
        ]);

        //register it to course order 
        CourseOrder::create([
            'course_id' => $this->courseId,
            'order_id' => $order->id,
            'quantity' => 1
        ]);

        // make transaction new order for free course 
        $order->transactions()->create(
            ['transaction' => OrderTransaction::NEW_ORDER]
        );


        // update  order to payment completed == change it to free  
        $order->update(['order_status' => Order::Free]);

        // update order transaction to completed == change it to free
        $order->transactions()->create([
            'transaction' => OrderTransaction::Free,
            'transaction_number' => $ref_id,
            'payment_result' => 'success',
        ]);

        // redirect student to his enrolled coursed to see his new course 
        redirect()->route("customer.courses");
    }
}
