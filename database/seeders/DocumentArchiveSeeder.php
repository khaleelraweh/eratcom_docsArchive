<?php

namespace Database\Seeders;

use App\Models\DocumentArchive;
use App\Models\DocumentCategory;
use App\Models\DocumentType;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $document_categories = DocumentCategory::active()->pluck('id');
        $document_types = DocumentType::active()->pluck('id');

        DocumentArchive::create([
            'doc_archive_name' => ['ar' =>  'وثيقة 1', 'en' =>  'Document 1'],
            'doc_archive_attached_file' =>  '1.pdf',
            'document_category_id'  =>  $document_categories->random(),
            'document_type_id'  =>  $document_types->random(),
            'created_by' => 'Admin System',
            'status' => true,
            'published_on' => $faker->dateTime(),
        ]);

        DocumentArchive::create([
            'doc_archive_name' => ['ar' =>  'وثيقة 2', 'en' =>  'Document 2'],
            'doc_archive_attached_file' =>  '2.pdf',
            'document_category_id'  =>  $document_categories->random(),
            'document_type_id'  =>  $document_types->random(),
            'created_by' => 'Admin System',
            'status' => true,
            'published_on' => $faker->dateTime(),
        ]);
    }
}
