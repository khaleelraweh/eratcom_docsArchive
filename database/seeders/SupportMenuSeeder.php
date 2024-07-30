<?php

namespace Database\Seeders;

use App\Models\WebMenu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        WebMenu::create(['title'  => ['ar' => 'توثيق', 'en' => 'Documentation'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'المنتديات', 'en' => 'Forums'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'حزم اللغات', 'en' => 'Language Packs'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'حالة الإصدار', 'en' => 'Release Status'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
