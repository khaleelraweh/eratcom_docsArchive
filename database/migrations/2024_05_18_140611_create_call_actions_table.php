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
        Schema::create('call_actions', function (Blueprint $table) {
            $table->id();

            $table->json('title');
            $table->json('slug');
            $table->json('description');
            $table->json('btn_name');
            $table->json('btn_link');

            $table->string('target')->default('_self');
            $table->unsignedBigInteger('section')->default(1);

            $table->boolean('showInfo')->default(true); // عرض العنوان والتصفاصيل 


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
        Schema::dropIfExists('call_actions');
    }
};
