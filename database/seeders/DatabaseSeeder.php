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

        $this->call(SpecializationSeeder::class);
        $this->call(EntrustSeeder::class);
        // $this->call(UserAddressSeeder::class); //This will be only for user khaleel user
        $this->call(CourseCategorySeeder::class);
        $this->call(CourseSeeder::class);


        $this->call(TagSeeder::class);
        // $this->call(ProductSeeder::class);
        $this->call(MainSliderSeeder::class);
        $this->call(AdvSliderSeeder::class);
        $this->call(CouponSeeder::class);
        // $this->call(ShippingCompanySeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(PaymentCategorySeeder::class);
        $this->call(PaymentMethodOfflineSeeder::class);

        $this->call(WebMenuSeeder::class);
        $this->call(CompanyMenuSeeder::class);
        $this->call(TopicsMenuSeeder::class);
        $this->call(TracksMenuSeeder::class);
        $this->call(SupportMenuSeeder::class);

        $this->call(SiteSettingSeeder::class);

        $this->call(CurrencySeeder::class);

        $this->call(PostSeeder::class);
        $this->call(EventSeeder::class);

        // last called 
        $this->call(TopicSeeder::class);
        $this->call(ObjectiveSeeder::class);
        $this->call(RequirementSeeder::class);
        $this->call(IntendedSeeder::class);

        $this->call(PhotoSeeder::class);
        $this->call(ReviewSeeder::class);


        $this->call(CourseSectionSeeder::class);
        $this->call(LessonSeeder::class);


        $this->call(CallActionSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(DocumentCategorySeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(DocumentTemplateSeeder::class);
        $this->call(DocumentArchiveSeeder::class);
    }
}
