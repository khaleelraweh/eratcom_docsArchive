<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // requirements list for courses
        // $requirementsList = [
        //     [
        //         "course_requirement" => [
        //             "ar" => "لا نطلب أي خبرة سابقة أو مهارات محددة مسبقًا لحضور هذه الدورة. سيكون التوجيه الجيد كافيًا لإتقان تصميم واجهة المستخدم/تجربة المستخدم.",
        //             "en" => "We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design."
        //         ],
        //     ],
        //     [
        //         "course_requirement" => [
        //             "ar" => "جهاز كمبيوتر مع اتصال جيد بالإنترنت.",
        //             "en" => "A computer with a good internet connection."
        //         ],
        //     ],
        //     [
        //         "course_requirement" => [
        //             "ar" => "أدوبي فوتوشوب (اختياري)",
        //             "en" => "Adobe Photoshop (OPTIONAL)"
        //         ],
        //     ],
        // ];

        $requirements = [
            ['title' => ["ar"  => "لا نطلب أي خبرة سابقة أو مهارات محددة مسبقًا لحضور هذه الدورة. سيكون التوجيه الجيد كافيًا لإتقان تصميم واجهة المستخدم/تجربة المستخدم.", "en"  => "We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design."]],
            ['title' => ["ar"  => "جهاز كمبيوتر مع اتصال جيد بالإنترنت.", "en" => "A computer with a good internet connection."]],
            ['title' => ["ar"  => "أدوبي فوتوشوب (اختياري)", "en"  => "Adobe Photoshop (OPTIONAL)"]],
        ];

        Course::all()->each(function ($course) use ($requirements) {
            $course->requirements()->createMany($requirements);
        });
    }
}
