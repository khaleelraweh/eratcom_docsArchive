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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');

            $table->json('description');
            $table->json('motavation')->nullable();
            $table->foreignId('course_category_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('section')->default(1); // 1 is post



            $table->string('video_promo')->nullable();
            $table->double('price')->default(0.0);
            $table->double('offer_price')->nullable()->default(0.0);
            $table->date('offer_ends')->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->string('address')->nullable();



            // will be use always
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('posts');
    }
};
