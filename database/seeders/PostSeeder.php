<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
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
            // Generate a random number of days between 1 and 10
            $randomDays = mt_rand(1, 10);

            // Generate a start date within the current month and within the range of the next one to ten days
            $startDate = $faker->dateTimeBetween('now', "+$randomDays days");


            // Generate an end date within the same year, after the start date
            $endDate = $faker->dateTimeBetween($startDate->format('Y-m-d'), $startDate->format('Y-m-d') . ' +1 year');


            $startTime = $faker->time('H:i:s');
            $endTime = $faker->time('H:i:s');

            $post = Post::create([
                'title' => $courseData['title'],


                'description' => ['ar' => 'مرحباً جميعاً. أنا أراش وأنا مصمم UI/UX. في هذه الدورة سوف أساعد
                تتعلم وتتقن تطبيق Figma بشكل شامل من الصفر. Figma هي أداة مبتكرة ورائعة
                لتصميم واجهة المستخدم. يتم استخدامه من قبل الجميع بدءًا من رواد الأعمال والشركات الناشئة وحتى Apple وAirbnb Anim pariatur cliche reprehenderit, enim
                إيوسمود هاي لايف يتهم تيري ريتشاردسون آد سكويد. Nihil anim Keffiyeh Helvetica، عمل البيرة الحرفية
                Wes anderson Cred nesciunt sapiente سأساعدك على التعلم وإتقان تطبيق Figma بشكل شامل من
                يخدش. Figma هي أداة مبتكرة ورائعة لتصميم واجهة المستخدم. يتم استخدامه من قبل الجميع من
                رواد الأعمال ea proident.
                الفيسبوك، الخ.', 'en' => ' Hi everyone. I\'m Arash and I\'m a UI/UX designer. In this course, I will help
                you learn and master Figma app comprehensively from scratch. Figma is an innovative and brilliant tool
                for User Interface design. It\'s used by everyone from entrepreneurs and start-ups to Apple, Airbnb Anim pariatur cliche reprehenderit, enim
                eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore
                wes anderson cred nesciunt sapiente I will help you learn and master Figma app comprehensively from
                scratch. Figma is an innovative and brilliant tool for User Interface design. It\'s used by everyone from
                entrepreneurs ea proident.,
                Facebook, etc.'],
                'course_category_id' => $courseData['course_category_id'],

                'motavation'    =>  ['ar' => 'هل تريد أن تصبح مصمم UI/UX لكنك لا تعرف من أين تبدأ؟ ستتيح لك هذه الدورة تطوير مهاراتك في تصميم واجهة المستخدم ويمكنك إضافة مصمم واجهة المستخدم إلى سيرتك الذاتية والبدء في جذب العملاء لمهاراتك.',    'en'    =>  'Do you want to become a UI/UX designer but you don\'t know where to start? This course will allow you to develop your user interface design skills and you can add UI designer to your CV and start getting clients for your skills.'],

                'video_promo' => "https://www.youtube.com/watch?v=9vn_e_XPV4s&list=PL_hXcCj5NytUlkH1XgfsjHAhJ0QHXM_xO",
                'price' => $faker->numberBetween(5, 200),
                'offer_price' => $faker->numberBetween(5, 100),
                'offer_ends' => $faker->dateTime(),

                'start_date' => $startDate,
                'end_date' => $endDate,

                'start_time' => $startTime,
                'end_time' => $endTime,

                'address'  =>  $faker->city . ' , ' . $faker->country(),
                'section'   =>  1,

                'status' => true,
                'published_on' => $faker->dateTime(),
                'created_by' => $faker->realTextBetween(10, 20),
                'updated_by' => $faker->realTextBetween(10, 20), // Assuming you want this as well
            ]);

            // Shuffle the collection of users
            $shuffledUsers = $users->shuffle();

            // Take the first 3 users from the shuffled collection
            $selectedUsers = $shuffledUsers->take(3);

            // Attach users
            $post->users()->attach($selectedUsers->pluck('id')->toArray());
        }
    }
}
