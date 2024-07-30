<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSection;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $fakerAr = Factory::create('ar_JO');


        // Get all courses
        $courses = Course::all();

        foreach ($courses as $course) {


            CourseSection::create([
                'title' => ['ar' => 'تجهيز الملفات الاساسية', 'en' => 'Preparing basic files'],
                'lectures_count' => 6,
                'duration' => "1hr 31m",
                'objective' => $faker->realText(),
                'course_id' => $course->id,

                'status' => true,
                'published_on' => $faker->dateTime(),
                'created_by' => $faker->realTextBetween(10, 20),
                'updated_by' => $faker->realTextBetween(10, 20),
            ]);

            // CourseSection::create([
            //     'title' => ['ar' => 'الادوار والصلاحيات', 'en' => 'Roules and Permissions'],
            //     'lectures_count' => 11,
            //     'duration' => "3hr 53m",
            //     'course_id' => $course->id,

            //     'status' => true,
            //     'published_on' => $faker->dateTime(),
            //     'created_by' => $faker->realTextBetween(10, 20),
            //     'updated_by' => $faker->realTextBetween(10, 20),
            // ]);

            // CourseSection::create([
            //     'title' => ['ar' => ' بناء لوحة التحكم', 'en' => 'Build the control panel'],
            //     'lectures_count' => 31,
            //     'duration' => "19hr 15m",
            //     'course_id' => $course->id,

            //     'status' => true,
            //     'published_on' => $faker->dateTime(),
            //     'created_by' => $faker->realTextBetween(10, 20),
            //     'updated_by' => $faker->realTextBetween(10, 20),
            // ]);

            //random section title 
            // for ($i = 0; $i < 3; $i++) {
            //     CourseSection::create([
            //         'title' => ['ar' => $fakerAr->sentence(3), 'en' => $faker->sentence(3)],
            //         'lectures_count' => $faker->numberBetween(5, 20),
            //         'duration' => $faker->time('H:i', 'now'),
            //         'course_id' => $course->id,

            //         'status' => true,
            //         'published_on' => $faker->dateTime(),
            //         'created_by' => $faker->name(),
            //         'updated_by' => $faker->name(),
            //     ]);
            // }
        }
    }
}
