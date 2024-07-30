<?php

namespace Database\Seeders;

use App\Models\PaymentCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $onlineGateway = PaymentCategory::create(['title' => ['ar' => 'الدفع الالكتروني', 'en' => 'Online Payment', 'ca' => 'pago en línea'],   'description' => ['ar' => $faker->paragraph(), 'en' => $faker->paragraph(), 'ca' => $faker->paragraph()], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime()]);
        $bankTransfer = PaymentCategory::create(['title' => ['ar' => 'حوالة بنكية', 'en' => 'Bank Transfer', 'ca' => 'transferencia bancaria'],   'description' => ['ar' => $faker->paragraph(), 'en' => $faker->paragraph(), 'ca' => $faker->paragraph()], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime()]);
        $electronicWallet = PaymentCategory::create(['title' => ['ar' => 'محفظة بنكية', 'en' => 'Electronic Wallet', 'ca' => 'Monedero electrónico'],   'description' => ['ar' => $faker->paragraph(), 'en' => $faker->paragraph(), 'ca' => $faker->paragraph()], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime()]);
        $electronicCard = PaymentCategory::create(['title' => ['ar' => 'بطاقة الكترونية', 'en' => 'Electronic Card', 'ca' => 'Tarjeta electrónica'],   'description' => ['ar' => $faker->paragraph(), 'en' => $faker->paragraph(), 'ca' => $faker->paragraph()], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime()]);
    }
}
