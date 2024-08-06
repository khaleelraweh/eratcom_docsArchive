<?php

namespace Database\Seeders;

use App\Models\DocumentPage;
use App\Models\DocumentTemplate;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $dts = DocumentTemplate::query()->pluck('id');

        DocumentPage::create([
            'doc_page_name' => $faker->text(),
            'doc_page_description' =>  $faker->text(),
            'document_template_id'  =>  $dts->random(),
            'created_at' => $faker->dateTime(),

        ]);

        DocumentPage::create([
            'doc_page_name' => $faker->text(),
            'doc_page_description' =>  $faker->text(),
            'document_template_id'  =>  $dts->random(),
            'created_at' => $faker->dateTime(),
        ]);
    }
}
