<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $categories = [
            [
                'title' => ['ar' => 'تطوير الذات', 'en' => 'Personal Development'],
                'description' => ['ar' => 'اكثر من 100 دورة', 'en' => 'Over 100 Courses'],
                'icon' => 'far fa-file-alt',
            ],
            [
                'title' => ['ar' => 'تطوير البرمجيات', 'en' => 'Software Development'],
                'description' => ['ar' => 'اكثر من 250 دورة', 'en' => 'Over 250 Courses'],
                'icon' => 'fas fa-laptop-code',
            ],
            [
                'title' => ['ar' => 'إدارة اعمال', 'en' => 'Business'],
                'description' => ['ar' => 'اكثر من 500 دورة', 'en' => 'Over 500 Courses'],
                'icon' => 'fas fa-briefcase',
            ],
            // [
            //     'title' => ['ar' => 'تصميم', 'en' => 'Design'],
            //     'description' => ['ar' => 'اكثر من 960 دورة', 'en' => 'Over 960 Courses'],
            //     'icon' => 'fas fa-bezier-curve',
            // ],
            // [
            //     'title' => ['ar' => 'المالية والمحاسبة', 'en' => 'Finance and Accounting'],
            //     'description' => ['ar' => 'اكثر من 320 دورة', 'en' => 'Over 320 Courses'],
            //     'icon' => 'fas fa-wallet',
            // ],
            // [
            //     'title' => ['ar' => 'تسويق', 'en' => 'Marketing'],
            //     'description' => ['ar' => 'اكثر من 960 دورة', 'en' => 'Over 960 Courses'],
            //     'icon' => 'fas fa-bullhorn',
            // ],
            // [
            //     'title' => ['ar' => 'الصوت والموسيقى', 'en' => 'Audio and Music'],
            //     'description' => ['ar' => 'اكثر من 200 دورة', 'en' => 'Over 200 Courses'],
            //     'icon' => 'fas fa-music',
            // ],
            // [
            //     'title' => ['ar' => 'التصوير', 'en' => 'Photography'],
            //     'description' => ['ar' => 'اكثر من 120 دورة', 'en' => 'Over 120 Courses'],
            //     'icon' => 'fas fa-camera',
            // ],
            // [
            //     'title' => ['ar' => 'المحاماة', 'en' => 'Law firm'],
            //     'description' => ['ar' => 'اكثر من 120 دورة', 'en' => 'Over 120 Courses'],
            //     'icon' => 'fas fa-camera',
            // ],
            // [
            //     'title' => ['ar' => 'علم الفضاء', 'en' => 'Space science'],
            //     'description' => ['ar' => 'اكثر من 120 دورة', 'en' => 'Over 120 Courses'],
            //     'icon' => 'fas fa-camera',
            // ],
            // [
            //     'title' => ['ar' => 'العلوم', 'en' => 'science'],
            //     'description' => ['ar' => 'اكثر من 120 دورة', 'en' => 'Over 120 Courses'],
            //     'icon' => 'fas fa-camera',
            // ],
            // [
            //     'title' => ['ar' => 'الفيزياء', 'en' => 'Physics'],
            //     'description' => ['ar' => 'اكثر من 120 دورة', 'en' => 'Over 120 Courses'],
            //     'icon' => 'fas fa-camera',
            // ],
            // [
            //     'title' => ['ar' => 'الاحياء', 'en' => 'ahua'],
            //     'description' => ['ar' => 'اكثر من 120 دورة', 'en' => 'Over 120 Courses'],
            //     'icon' => 'fas fa-camera',
            // ],
        ];

        foreach ($categories as $category) {
            CourseCategory::create([
                'title' => $category['title'],
                'description' => $category['description'],
                'icon' => $category['icon'],
                'created_by' => 'admin',
                'status' => true,
                'published_on' => $faker->dateTime(),
                'parent_id' => null,
            ]);
        }
    }
}
