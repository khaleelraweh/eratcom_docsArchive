<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Course::all()->each(function ($course) use ($faker) {

            $course->reviews()->create([
                // 'user_id'   =>  rand(3, 23),
                'user_id'   =>  1,
                'name'      =>  $faker->userName(),
                'email'     =>  $faker->safeEmail(),
                'title'     =>  $faker->sentence(),
                'message'   =>  $faker->paragraph(),
                'status'    =>  rand(0, 1),
                'rating'    =>  rand(1, 5),
            ]);
        });

        Post::all()->each(function ($post) use ($faker) {

            $post->reviews()->create([
                // 'user_id'   =>  rand(3, 23),
                'user_id'   =>  1,
                'name'      =>  $faker->userName(),
                'email'     =>  $faker->safeEmail(),
                'title'     =>  $faker->sentence(),
                'message'   =>  $faker->paragraph(),
                'status'    =>  rand(0, 1),
                'rating'    =>  rand(1, 5),
            ]);
        });
    }
}
