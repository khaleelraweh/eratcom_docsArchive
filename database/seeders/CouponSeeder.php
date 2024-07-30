<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code'          =>  ['ar' => 'سامي1200', 'en' => 'SAMI200', 'ca' => 'SAMI200Span'],
            'description'   =>  ['ar' => 'تخفيض بقيمة 200 ريال في المبيعات عبر موقع الويب', 'en' => 'Discount 200 SAR on your sales on website', 'ca' => 'Descuento de 200 SAR en sus ventas en el sitio web'],
            'type'          =>  'fixed',
            'value'         =>  200,
            'use_times'     =>  20,
            'start_date'    =>  Carbon::now(),
            'expire_date'   =>  Carbon::now()->addMonth(),
            'greater_than'  =>  600,
            'status'        =>  1,
        ]);

        Coupon::create([
            'code'          =>  ['ar' => 'نص القيمة', 'en' => 'fiftyfifty', 'ca' => 'cincuenta cincuenta'],
            'description'   =>  ['ar' => 'تخفيض بقيمة 50% عند الشراء من خلال الموقع ', 'en' => 'Discount 50%  on your sales on website', 'ca' => 'Descuento 50% en tus ventas en web'],
            'type'          => 'percentage',
            'value'         =>  50,
            'use_times'     =>  5,
            'start_date'    =>  Carbon::now(),
            'expire_date'   =>  Carbon::now()->addWeek(),
            'greater_than'  =>  null,
            'status'        =>  1,
        ]);
    }
}
