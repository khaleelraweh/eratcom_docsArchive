<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        // Get active instructor
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->active()->inRandomOrder()->take(10)->get();

        // Get active course categories
        $categories = CourseCategory::active()->pluck('id');


        // Loop through courses data
        $coursesData = [
            [
                'title' => ['ar' => 'مؤتمر تصميم جديد لصندوق الضوء الأنيق من قطع الورق', 'en' => 'Elegant Light Box Paper Cut Dioramas New Design Conference'],
                'course_category_id' => 1,
            ],
            // [
            //     'title' => ['ar' => 'اكتشف القانون - التحق بأفضل كليات الحقوق في المملكة المتحدة', 'en' => 'Discover Law - Get into the best UK law schools'],
            //     'course_category_id' => 2,
            // ],
            // [
            //     'title' => ['ar' => '"مقدمة في القانون" يوم مفتوح مع بريستو', 'en' => '"Introduction to Law" Open Day with Bristows'],
            //     'course_category_id' => 3,
            // ],
            // [
            //     'title' => ['ar' => 'حماية لامبث: فهم الضرر السياقي', 'en' => 'Lambeth Safeguarding: Understanding Contextual Harm'],
            //     'course_category_id' => 4,
            // ],
            // [
            //     'title' => ['ar' => 'اليوم المفتوح للطلاب الجامعيين - حرم هولواي الجامعي - 3 يوليو 2020', 'en' => 'Undergraduate Open Day – Holloway Campus - 3 July 2020'],
            //     'course_category_id' => 5,
            // ],
            // [
            //     'title' => ['ar' => 'الأحداث المفتوحة للطلاب الجامعيين في جامعة كينجستون 2019-20', 'en' => 'Kingston College undergraduate Open Events 2019-20'],
            //     'course_category_id' => 6,
            // ],
            // [
            //     'title' => ['ar' => 'مؤتمر تصميم جديد لصندوق الضوء الأنيق من قطع الورق', 'en' => 'Elegant Light Box Paper Cut Dioramas New Design Conference'],
            //     'course_category_id' => 1,
            // ],
            // [
            //     'title' => ['ar' => 'اكتشف القانون - التحق بأفضل كليات الحقوق في المملكة المتحدة', 'en' => 'Discover Law - Get into the best UK law schools'],
            //     'course_category_id' => 2,
            // ],
            // [
            //     'title' => ['ar' => '"مقدمة في القانون" يوم مفتوح مع بريستو', 'en' => '"Introduction to Law" Open Day with Bristows'],
            //     'course_category_id' => 3,
            // ],
            // [
            //     'title' => ['ar' => 'حماية لامبث: فهم الضرر السياقي', 'en' => 'Lambeth Safeguarding: Understanding Contextual Harm'],
            //     'course_category_id' => 4,
            // ],
            // [
            //     'title' => ['ar' => 'اليوم المفتوح للطلاب الجامعيين - حرم هولواي الجامعي - 3 يوليو 2020', 'en' => 'Undergraduate Open Day – Holloway Campus - 3 July 2020'],
            //     'course_category_id' => 5,
            // ],
            // [
            //     'title' => ['ar' => 'الأحداث المفتوحة للطلاب الجامعيين في جامعة كينجستون 2019-20', 'en' => 'Kingston College undergraduate Open Events 2019-20'],
            //     'course_category_id' => 6,
            // ],
            // [
            //     'title' => ['ar' => 'مؤتمر تصميم جديد لصندوق الضوء الأنيق من قطع الورق', 'en' => 'Elegant Light Box Paper Cut Dioramas New Design Conference'],
            //     'course_category_id' => 1,
            // ],
            // [
            //     'title' => ['ar' => 'اكتشف القانون - التحق بأفضل كليات الحقوق في المملكة المتحدة', 'en' => 'Discover Law - Get into the best UK law schools'],
            //     'course_category_id' => 2,
            // ],
            // [
            //     'title' => ['ar' => '"مقدمة في القانون" يوم مفتوح مع بريستو', 'en' => '"Introduction to Law" Open Day with Bristows'],
            //     'course_category_id' => 3,
            // ],
            // [
            //     'title' => ['ar' => 'حماية لامبث: فهم الضرر السياقي', 'en' => 'Lambeth Safeguarding: Understanding Contextual Harm'],
            //     'course_category_id' => 4,
            // ],
            // [
            //     'title' => ['ar' => 'اليوم المفتوح للطلاب الجامعيين - حرم هولواي الجامعي - 3 يوليو 2020', 'en' => 'Undergraduate Open Day – Holloway Campus - 3 July 2020'],
            //     'course_category_id' => 5,
            // ],
            // [
            //     'title' => ['ar' => 'الأحداث المفتوحة للطلاب الجامعيين في جامعة كينجستون 2019-20', 'en' => 'Kingston College undergraduate Open Events 2019-20'],
            //     'course_category_id' => 6,
            // ],

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
                'video_promo' => "https://www.youtube.com/watch?v=9vn_e_XPV4s&list=PL_hXcCj5NytUlkH1XgfsjHAhJ0QHXM_xO",
                'video_description' => "https://www.youtube.com/watch?v=N2EfGEPI_q8&list=PL_hXcCj5NytUlkH1XgfsjHAhJ0QHXM_xO&index=4",
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
                'section'   =>  2,

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
