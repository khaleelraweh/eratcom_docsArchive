<?php

namespace Database\Seeders;

use App\Models\CallAction;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CallActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $target = ['_self', '_blank'];

        for ($i = 1; $i <= 1; $i++) {
            $sliders[] = [
                'title'         => json_encode(['ar' => 'عزز مهاراتك مع أفضل الدورات التدريبية عبر الإنترنت' . $i, 'en' => 'ENHANCE YOUR SKILLS WITH BEST ONLINE COURSES' . $i]),
                'slug'          => json_encode(['ar' => $faker->unique()->slug(3), 'en' => $faker->unique()->slug(3)]),
                'description'   => json_encode(['ar' => 'البدء بالتعلم عبر الإنترنت', 'en' => 'STARTING ONLINE LEARNING']),

                'btn_name'      => json_encode(['ar' => 'لنبداء الآن', 'en' => 'GET STARTED NOW']),
                'btn_link'      => json_encode(['ar' => $faker->url(), 'en' => $faker->url()]),
                'target'        =>  Arr::random($target),
                'published_on'  =>  $faker->dateTime(),
                'created_by'    =>  $faker->realTextBetween(10, 12),
                'updated_by'    =>  $faker->realTextBetween(10, 12),
                'deleted_at'    =>  null,
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ];
        }

        $chuncks = array_chunk($sliders, 100);
        foreach ($chuncks as $chunck) {
            CallAction::insert($chunck);
        }
    }
}
