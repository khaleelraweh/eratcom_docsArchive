<?php

namespace Database\Seeders;

use App\Models\DocumentData;
use App\Models\PageVariable;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $pvs = PageVariable::query()->pluck('id');

        $docDataTypes = ['text', 'number'];


        DocumentData::create([
            'doc_data_name' => $faker->name(),
            'doc_data_value' =>  $faker->text(),
            'doc_data_type'  =>  $faker->randomElement($docDataTypes),
            'page_variable_id'  =>  $pvs->random(),

        ]);

        DocumentData::create([
            'doc_data_name' => $faker->name(),
            'doc_data_value' =>  $faker->text(),
            'doc_data_type'  =>  $faker->randomElement($docDataTypes),
            'page_variable_id'  =>  $pvs->random(),

        ]);
    }
}
