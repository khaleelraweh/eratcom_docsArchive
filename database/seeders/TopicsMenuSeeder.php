<?php

namespace Database\Seeders;

use App\Models\WebMenu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        WebMenu::create(['title'  => ['ar' => 'إتش تي إم إل ', 'en' => 'HTML'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => ' سي إس إس', 'en' => 'CSS'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'التصميم', 'en' => 'Design'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'جافا سكربت', 'en' => 'Javascript'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'روبي', 'en' => 'Ruby'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'بي إتش بي', 'en' => 'PHP'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'اندرويد', 'en' => 'Android'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'ادوات التصميم', 'en' => 'Development Tools'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'إدارة الاعمال', 'en' => 'Business'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
