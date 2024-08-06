<?php

namespace Database\Seeders;

use App\Models\PageGroup;
use App\Models\PageVariable;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageVariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $pgs = PageGroup::query()->pluck('id');
        $docDataTypes = ['text', 'number'];
        $docDataRequired = [0, 1];


        PageVariable::create([
            'pv_name' => $faker->text(),
            'pv_question' =>  $pgs->random(),
            'pv_type'       =>  $faker->randomElement($docDataTypes),
            'pv_required'   =>  $faker->randomElement($docDataRequired),
            'pv_details'    =>  $faker->text(),
            'page_group_id' =>  $pgs->random(),
            'created_at' => $faker->dateTime(),
        ]);


        PageVariable::create([
            'pv_name' => $faker->text(),
            'pv_question' =>  $pgs->random(),
            'pv_type'       =>  $faker->randomElement($docDataTypes),
            'pv_required'   =>  $faker->randomElement($docDataRequired),
            'pv_details'    =>  $faker->text(),
            'page_group_id' =>  $pgs->random(),
            'created_at' => $faker->dateTime(),
        ]);
    }
}
