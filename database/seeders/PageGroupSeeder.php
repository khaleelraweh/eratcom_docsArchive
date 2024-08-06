<?php

namespace Database\Seeders;

use App\Models\DocumentPage;
use App\Models\PageGroup;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $dps = DocumentPage::query()->pluck('id');

        PageGroup::create([
            'pg_name' => $faker->text(),
            'document_page_id' =>  $dps->random(),
            'created_at' => $faker->dateTime(),

        ]);

        PageGroup::create([
            'pg_name' => $faker->text(),
            'document_page_id' =>  $dps->random(),
            'created_at' => $faker->dateTime(),

        ]);
    }
}
