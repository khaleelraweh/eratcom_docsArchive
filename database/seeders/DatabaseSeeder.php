<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        $this->call(WorldSeeder::class);
        $this->call(WorldStatusSeeder::class);
        $this->call(EntrustSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(PhotoSeeder::class);

        $this->call(DocumentCategorySeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(DocumentTemplateSeeder::class);
        $this->call(DocumentArchiveSeeder::class);

        $this->call(DocumentPageSeeder::class);
        $this->call(PageGroupSeeder::class);

        // $this->call(DocumentDataSeeder::class);
    }
}
