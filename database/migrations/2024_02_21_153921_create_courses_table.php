<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->json('subtitle')->nullable();
            $table->json('description')->nullable();

            $table->tinyInteger('skill_level')->nullable()->default(1); // واحد مبتدي اثنين متوسط ثلاثة متقدم
            $table->tinyInteger('language')->nullable()->default(1); // واحد عربي اثنين إنجليزي ثلاثة اسباني
            $table->tinyInteger('evaluation')->nullable()->default(1); // 1 : is normal , 2 : is featured  , 3 : is best seller
            $table->tinyInteger('lecture_numbers')->nullable();
            $table->string('course_duration')->nullable();

            // added by alyamany
            $table->string('video_promo')->nullable();
            $table->string('video_description')->nullable();
            $table->tinyInteger('course_type')->nullable()->default(1);   //  1: mean presence 2 : enrolled

            $table->dateTime('deadline')->nullable();
            $table->boolean('certificate')->nullable()->default(true);


            $table->double('price')->nullable()->default(0.0);
            $table->double('offer_price')->nullable()->default(0.0); // سعر العرض
            $table->date('offer_ends')->nullable(); // تاريخ انتهاء العرض 
            $table->boolean('featured')->default(false);
            $table->foreignId('course_category_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('instructor_id')->constrained()->cascadeOnDelete();
            $table->integer('progress')->default(10);

            $table->integer('views')->default(0);

            // for events only 
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->json('address')->nullable();

            $table->unsignedTinyInteger('course_status')->default(0);
            $table->boolean('admin_review')->nullable()->default(false);

            //end for events only 
            $table->unsignedBigInteger('section')->default(1); // one is course , two is event 


            // will be use always
            $table->boolean('status')->nullable()->default(false);
            $table->dateTime('published_on')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // end of will be use always
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
