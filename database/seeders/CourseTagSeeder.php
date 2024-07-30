<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CourseTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::whereStatus(true)->pluck('id')->toArray();

        Course::all()->each(function ($product) use ($tags) {
            $product->tags()->attach(Arr::random($tags, rand(2, 3)));
        });
    }
}
