<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\WebMenu;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $course = Page::create([
            'title' => ['ar' => 'العنوان', 'en' => 'title'],
            'description' => ['ar' => $faker->realText(50), 'en' => $faker->realText(50), 'ca' => $faker->realText(50)],
            'status' => true,
            'published_on' => Carbon::now(),
            'created_by' => $faker->realTextBetween(10, 20),
            'updated_by' => $faker->realTextBetween(10, 20), // Assuming you want this as well
        ]);
    }
}
