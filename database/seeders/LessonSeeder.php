<?php

namespace Database\Seeders;

use App\Models\CourseSection;
use App\Models\Lesson;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        // one 
        Lesson::create([
            'title' => ['ar' => 'مقدمة مهمة جدا', 'en' => 'Very Important Introduction'],
            'url'      =>  'https://www.youtube.com/embed/4OGWPn-Q__I?si=Rrw3o9boTvacjX4M',

            'duration_minutes' => '12',
            'course_section_id' => 1,

            'status' => true,
            'published_on' => $faker->dateTime(),
            'created_by' => $faker->name(),
            'updated_by' => $faker->name(),
        ]);

        // tow 
        Lesson::create([
            'title' => ['ar' => 'الشريط الجانبي الجزء 1 وإنشاء الإطار', 'en' => 'Sidebar part 1 and Framework create '],
            'url'      =>  'https://www.youtube.com/embed/DjLINOE4auA?si=_EqOOsx11EXwbQKC',

            'duration_minutes' => '15',
            'course_section_id' => 1,

            'status' => true,
            'published_on' => $faker->dateTime(),
            'created_by' => $faker->name(),
            'updated_by' => $faker->name(),
        ]);

        // three
        Lesson::create([
            'title' => ['ar' => 'الشريط الجانبي الجزء 2 والعمل الكامل', 'en' => ' Sidebar part 2 and Complete Work'],
            'url'      =>  'https://www.youtube.com/embed/Rnhv3_tiJhw?si=C4XiDXv-XINCDzae',

            'duration_minutes' => '16',
            'course_section_id' => 1,

            'status' => true,
            'published_on' => $faker->dateTime(),
            'created_by' => $faker->name(),
            'updated_by' => $faker->name(),
        ]);

        // four
        Lesson::create([
            'title' => ['ar' => 'إنشاء عنوان منطقة المحتوى', 'en' => 'Create Content Area Heading'],
            'url'      =>  'https://www.youtube.com/embed/Lk0PTNu8ato?si=8m4O_EdzmOIeewaY',

            'duration_minutes' => '15',
            'course_section_id' => 1,

            'status' => true,
            'published_on' => $faker->dateTime(),
            'created_by' => $faker->name(),
            'updated_by' => $faker->name(),
        ]);

        // five
        Lesson::create([
            'title' => ['ar' => 'إنشاء عنوان الصفحة والتمرير', 'en' => 'Create Page Heading and Scrall'],
            'url'      =>  'https://www.youtube.com/embed/4Qgfg6KTCs0?si=RQhl9rS8goRMhDft',

            'duration_minutes' => '4',
            'course_section_id' => 1,

            'status' => true,
            'published_on' => $faker->dateTime(),
            'created_by' => $faker->name(),
            'updated_by' => $faker->name(),
        ]);

        //six 
        Lesson::create([
            'title' => ['ar' => 'إنشاء غلاف ومربعات القطعة', 'en' => 'Create Wrapper and Widget Boxes'],
            'url'      =>  'https://www.youtube.com/embed/NS5orQh7Q5U?si=WpdfNrbU72h4NfYx',

            'duration_minutes' => '7',
            'course_section_id' => 1,

            'status' => true,
            'published_on' => $faker->dateTime(),
            'created_by' => $faker->name(),
            'updated_by' => $faker->name(),
        ]);
    }
}
