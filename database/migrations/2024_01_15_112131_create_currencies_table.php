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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->json('currency_name');
            $table->json('slug');
            $table->json('currency_symbol');
            $table->string('currency_code')->nullable();
            $table->string('exchange_rate')->nullable();


            // will be use always
            $table->boolean('status')->default(true);
            $table->dateTime('published_on')->nullable();
            $table->string('created_by')->nullable()->default('admin');
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
        Schema::dropIfExists('currencies');
    }
};
