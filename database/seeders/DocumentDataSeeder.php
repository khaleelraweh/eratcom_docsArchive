<?php

namespace Database\Seeders;

use App\Models\DocumentData;
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
        DocumentData::create([
            'document_id' => 1, // Reference a seeded document
            'page_variable_id' => 1, // Reference a seeded page variable
            'value' => 'Test value for Variable 1'
        ]);

        DocumentData::create([
            'document_id' => 1, // Reference the same or a different document
            'page_variable_id' => 2, // Reference a different page variable
            'value' => '12345' // Example for a number type
        ]);
    }
}
