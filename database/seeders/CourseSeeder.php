<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        // $users = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'instructor');
        // })->active()->inRandomOrder()->take(10)->get();

        $users = User::WhereHasRoles('instructor')->active()->inRandomOrder()->take(10)->get();


        // Get active course categories
        $categories = CourseCategory::active()->pluck('id');




        // Loop through courses data
        $coursesData = [
            // [
            //     'title' => ['ar' => 'تصوير الأزياء من المحترفين', 'en' => 'Fashion Photography From Professional'],
            //     'course_category_id' => 8, // Assuming category ID 8 is for photography
            // ],
            // [
            //     'title' => ['ar' => 'دورة جافا سكريبت الكاملة 2020: بناء مشاريع حقيقية!', 'en' => 'The Complete JavaScript Course 2020: Build Real Projects!'],
            //     'course_category_id' => 2, // Assuming category ID 2 is for JavaScript
            // ],
            // [
            //     'title' => ['ar' => 'دورة جافا سكريبت الكاملة 2020: بناء مشاريع حقيقية!', 'en' => 'The Complete JavaScript Course 2020: Build Real Projects!'],
            //     'course_category_id' => 5, // Assuming category ID 4 is for programming
            // ],
            // [
            //     'title' => ['ar' => 'تعلم الشكل: أساسيات تصميم واجهة المستخدم - تصميم UI/UX', 'en' => 'Learn Figma: User Interface Design Essentials - UI/UX Design'],
            //     'course_category_id' => 4, // Assuming category ID 4 is for design
            // ],
            // [
            //     'title' => ['ar' => 'دورة المحلل المالي الكاملة 2020', 'en' => 'The Complete Financial Analyst Course 2020'],
            //     'course_category_id' => 1, // Random category
            // ],
            // [
            //     'title' => ['ar' => 'تصوير الأزياء من المحترفين', 'en' => 'Fashion Photography From Professional'],
            //     'course_category_id' => 3, // Random category
            // ],
            // [
            //     'title' => ['ar' => 'تصوير الذات', 'en' => 'Self development'],
            //     'course_category_id' => 6, // Random category
            // ],
            // [
            //     'title' => ['ar' => 'تصوير الذات', 'en' => 'Self development'],
            //     'course_category_id' => 7, // Random category
            // ],
            // [
            //     'title' => ['ar' => 'دورة في إدارة الاعمال', 'en' => 'Course in business administration'],
            //     'course_category_id' => 8, // Random category
            // ],
            // [
            //     'title' => ['ar' => 'دورة في التسويق', 'en' => 'Course in marketing'],
            //     'course_category_id' => 9, // Random category
            // ],
            // [
            //     'title' => ['ar' => 'دورة في الصوت والمسيقي', 'en' => 'A course in voice and music'],
            //     'course_category_id' => 10, // Random category
            // ],
            // [
            //     'title' => ['ar' => 'دورة في الصوت العلوم', 'en' => 'A course in Science'],
            //     'course_category_id' => 11, // Random category
            // ],
            [
                'title' => ['ar' => 'دورة في الفيزياء', 'en' => 'A course in  Physics'],
                'course_category_id' => $categories->random(), // Random category
            ],
            [
                'title' => ['ar' => 'دورة في علم الاحياء', 'en' => 'A course in ahua'],
                'course_category_id' => $categories->random(), // Random category
            ],
            [
                'title' => ['ar' => 'HTML and CSS Template 4', 'en' => 'HTML and CSS Template 4'],
                'course_category_id' => $categories->random(), // Random category
            ],

        ];

        // Loop through each course data and create courses
        foreach ($coursesData as $courseData) {

            $randomDays = mt_rand(1, 10);

            // Generate a start date within the current month and within the range of the next one to ten days
            $startDate = $faker->dateTimeBetween('now', "+$randomDays days");


            // Generate an end date within the same year, after the start date
            $endDate = $faker->dateTimeBetween($startDate->format('Y-m-d'), $startDate->format('Y-m-d') . ' +1 year');


            $startTime = $faker->time('H:i:s');
            $endTime = $faker->time('H:i:s');

            $course = Course::create([
                'title' => $courseData['title'],
                'subtitle' => ['ar' => 'عنوان فرعي', 'en' => 'subtitle'],
                'description' => ['ar' => $faker->realText(50), 'en' => $faker->realText(50), 'ca' => $faker->realText(50)],
                'skill_level' => 1,
                'language' => 1,
                'lecture_numbers' => 5,
                'course_duration' => "8h 12m",
                'video_promo' => "https://www.youtube.com/embed/4OGWPn-Q__I?si=Rrw3o9boTvacjX4M",
                'video_description' => "https://www.youtube.com/embed/4OGWPn-Q__I?si=Rrw3o9boTvacjX4M",
                'course_type' => 1,
                'deadline' => "2024-03-11",
                'certificate' => 1,
                'price' => $faker->numberBetween(5, 200),
                'offer_price' => $faker->numberBetween(5, 100),
                'offer_ends' => $faker->dateTime(),
                'featured' => rand(0, 1),


                'start_date' => $startDate,
                'end_date' => $endDate,

                'start_time' => $startTime,
                'end_time' => $endTime,

                'address'  =>  $faker->city . ' , ' . $faker->country(),
                'section'   =>  1,

                'status' => true,
                'course_category_id' => $courseData['course_category_id'],
                'published_on' => $faker->dateTime(),
                'created_by' => $faker->realTextBetween(10, 20),
                'updated_by' => $faker->realTextBetween(10, 20), // Assuming you want this as well
            ]);

            // Shuffle the collection of users
            $shuffledUsers = $users->shuffle();

            // Take the first 3 users from the shuffled collection
            $selectedUsers = $shuffledUsers->take(3);

            // Attach users
            $course->instructors()->attach($selectedUsers->pluck('id')->toArray());
        }
    }
}
