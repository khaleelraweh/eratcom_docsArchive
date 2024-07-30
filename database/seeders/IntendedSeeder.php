<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntendedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate sample data for intendeds
        $intendeds = [
            ['title' => ["ar"   => "مطورو لغة بايثون المبتدئون مهتمون بعلم البيانات", "en" => "Beginner python developers curious about data science"]],
        ];


        Course::all()->each(function ($course) use ($intendeds) {
            $course->intendeds()->createMany($intendeds);
        });
    }
}
