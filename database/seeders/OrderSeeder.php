<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        $khaleelUser = User::find(3);
        $products = Course::active()->inRandomOrder()->take(3)->get();
        $subTotalValue = $products->sum('price');
        $discountValue = $subTotalValue / 2;
        $shippingValue = 15.00;
        $taxValue = ($subTotalValue - $discountValue) * 0.15;
        $totalValue = $subTotalValue - $discountValue + $shippingValue + $taxValue;

        // Create Order 
        $order = $khaleelUser->orders()->create([
            'ref_id'    =>  Str::random(15),
            // 'user_address_id'   =>  1,
            // 'shipping_company_id'   =>  1,
            'payment_method_id' =>  1,
            'subtotal'  =>  $subTotalValue,
            'discount_code' =>  'fiftyfifty',
            'discount'  =>  $discountValue,
            'shipping'  =>  $shippingValue,
            'tax'   =>  $taxValue,
            'total' =>  $totalValue,
            'currency'  =>  'USD',
            'order_status'  =>  Order::PAYMENT_COMPLETED,

        ]);

        //Create Order Products 
        $order->courses()->attach($products->pluck('id')->toArray());

        // Create Order Transations
        $order->transactions()->createMany([
            [
                'transaction'   =>  Order::NEW_ORDER,
                'transaction_number'    =>  null,
                'payment_result'    =>  null,
            ],
            [
                'transaction'   =>  Order::PAYMENT_COMPLETED,
                'transaction_number'    =>  Str::random(15),
                'payment_result'    =>  'success',
            ],
        ]);

        /**
         * Create fake order for each user for all users whoes id is bigger than 3
         */

        //  User::where('id' , '>' , 3)->each(function ($user) use ($faker) {
        //         foreach(range(3,6) as $index ){
        //             $products = Product::active()->hasQuantity()->activeCategory()->inRandomOrder()->take(3)->get();
        //             $subTotalValue = $products->sum('price');
        //             $discountValue = $subTotalValue / 2;
        //             $shippingValue = 15.00;
        //             $taxValue = ($subTotalValue - $discountValue) * 0.15 ;
        //             $totalValue = $subTotalValue - $discountValue + $shippingValue + $taxValue ;
        //             $order_status = rand(0,8);

        //             // Create Order 
        //             $order = $user->orders()->create([
        //                 'ref_id'    =>  Str::random(15),
        //                 'user_address_id'   =>  $user->addresses()->first()->id,
        //                 'shipping_company_id'   =>  1,
        //                 'payment_method_id' =>  1,
        //                 'subtotal'  =>  $subTotalValue,
        //                 'discount_code' =>  'fiftyfifty',
        //                 'discount'  =>  $discountValue,
        //                 'shipping'  =>  $shippingValue,
        //                 'tax'   =>  $taxValue,
        //                 'total' =>  $totalValue,
        //                 'currency'  =>  'USD',
        //                 'order_status'  =>  $order_status,
        //                 'created_at' => $faker->dateTimeBetween('-10 months' , 'now'),
        //                 'updated_at' => $faker->dateTimeBetween('-10 months' , 'now'),

        //             ]);

        //             //Create Order Products 
        //             $order->products()->attach($products->pluck('id')->toArray());

        //             // Create Order Transations
        //             $order->transactions()->createMany([
        //                 [
        //                     'transaction'           =>  Order::NEW_ORDER,
        //                     'transaction_number'    =>  null,
        //                     'payment_result'        =>  null,
        //                 ],
        //                 [
        //                     'transaction'           =>  $order_status,
        //                     'transaction_number'    =>  Str::random(15),
        //                     'payment_result'        =>  'success',
        //                 ],
        //             ]);
        //         }
        //  });
    }
}
