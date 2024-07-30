<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObjectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate sample data for objectives
        $objectives = [
            ['title' => ["ar"   => "كن مصممًا لواجهة المستخدم/UX.", "en" => "Become a UI/UX designer."]],
            ['title' => ["ar"   => "ستكون قادرًا على البدء في كسب مهارات المال.", "en" => "You will be able to start earning money skills."]],
            ['title' => ["ar"   => "بناء مشروع واجهة المستخدم من البداية إلى النهاية.", "en" => "Build a UI project from beginning to end."]],
            ['title' => ["ar"   => "العمل مع الألوان والخطوط.", "en" => "Work with colors & fonts."]],
        ];


        Course::all()->each(function ($course) use ($objectives) {
            $course->objectives()->createMany($objectives);
        });
    }
}
