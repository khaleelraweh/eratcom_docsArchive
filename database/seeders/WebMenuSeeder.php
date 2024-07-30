<?php

namespace Database\Seeders;

use App\Models\WebMenu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $main = WebMenu::create(['title'  => ['ar' => 'الرئيسية', 'en' => 'Main'], 'icon'   => 'fa fa-home', 'link'  =>  'index', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);


        $courses = WebMenu::create(['title'  => ['ar' => 'الدورات', 'en' => 'Courses'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);

        $design  = WebMenu::create(['title'  => ['ar' => 'التصميم', 'en' => 'Design'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $courses->id]);
        // WebMenu::create(['title'  => ['ar' => 'فوتوشوب', 'en' => 'Photoshop'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $design->id]);
        // WebMenu::create(['title'  => ['ar' => 'جرافكس', 'en' => 'Graphics'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $design->id]);

        $web_developer = WebMenu::create(['title'  => ['ar' => 'البرمجة', 'en' => 'Development'], 'icon'   => 'fa fa-home', 'link'  =>  ['ar' =>     'courses-list/تطوير-البرمجيات',    'en' => 'courses-list/software-development'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $courses->id]);
        // WebMenu::create(['title'  => ['ar' => 'بي اتش بي', 'en' => 'Php'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $web_developer->id]);
        // WebMenu::create(['title'  => ['ar' => 'لارافل', 'en' => 'Laravel'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $web_developer->id]);


        $pages = WebMenu::create(['title'  => ['ar' => 'الصفحات', 'en' => 'Pages'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'من نحن', 'en' => 'About Us'], 'icon'   => 'fa fa-home', 'link' => 'about', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $pages->id]);
        WebMenu::create(['title'  => ['ar' => 'تواصل معنا', 'en' => 'Contact Us'], 'icon'   => 'fa fa-home', 'link' => 'contact-us', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $pages->id]);

        $instructors = WebMenu::create(['title'  => ['ar' => 'المحاضرون', 'en' => 'Instructors'], 'icon'   => 'fa fa-home', 'link'  =>  'instructors-list', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
