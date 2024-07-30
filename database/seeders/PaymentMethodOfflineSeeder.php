<?php

namespace Database\Seeders;

use App\Models\PaymentCategory;
use App\Models\PaymentMethodOffline;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodOfflineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * 1 : بوابة دفع الكتروني
         * 2 : حوالة بنكية 
         * 3 : محفظة الكترونية 
         * 4 : بطاقة الكترونية
         */
        $faker = Factory::create('ar_JO');

        $categories = PaymentCategory::whereStatus(true)->pluck('id');

        PaymentMethodOffline::create([
            'title'                         => ['ar' => 'بنك الكريمي', 'en' => 'Kuraimi Bank', 'ca' => 'Banco Kuraimi'],
            'description'                   => ['ar' => $faker->paragraph(), 'en' => $faker->paragraph(), 'ca' => $faker->paragraph()],

            // for owner account 
            'owner_account_name'            =>      'Mohammed Hutaif',
            'owner_account_number'          =>      '987654324',
            'owner_account_country'         =>      'Yemen',
            'owner_account_phone'           =>      '772036131',
            //end for owner account 

            // For customer account 
            'customer_account_name'         =>      'ali hamod',
            'customer_account_number'       =>      '235146',
            'customer_account_country'       =>      'Yemen',
            'customer_account_phone'        =>      '711131459',
            // End for cuatomer account 

            'payment_category_id'           =>      2,
            'status'                        =>      true,
            'published_on'                  =>      Carbon::now(),
            'created_by'                    =>      'admin'

        ]);
        PaymentMethodOffline::create([
            'title'                         => ['ar' => 'بنك التضامن', 'en' => 'Tadamon Bank', 'ca' => 'Banco Tadamon'],
            'description'                   => ['ar' => $faker->paragraph(), 'en' => $faker->paragraph(), 'ca' => $faker->paragraph()],

            // for owner account 
            'owner_account_name'            =>      'Mohammed Hutaif',
            'owner_account_number'          =>      '123456789',
            'owner_account_country'         =>      'Yemen',
            'owner_account_phone'           =>      '772036131',
            //end for owner account 

            // For customer account 
            'customer_account_name'         =>      'salem hamod',
            'customer_account_number'       =>      '235146',
            'customer_account_country'       =>      'Yemen',
            'customer_account_phone'        =>      '711131459',
            // End for cuatomer account 

            'payment_category_id'           =>      2,
            'status'                        =>      true,
            'published_on'                  =>      Carbon::now(),
            'created_by'                    =>      'admin'

        ]);
    }
}
