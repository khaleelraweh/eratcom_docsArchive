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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_native')->nullable();
            $table->char('country_code', 2)->nullable();
            $table->string('phone_code')->nullable();
            $table->string('capital')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_name_native')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('region')->nullable();
            $table->string('nationality')->nullable();
            $table->string('nationality_native')->nullable();
            $table->text('translations')->nullable();
            $table->string('emoji')->nullable();
            $table->boolean('status')->default(false);

            $table->dateTime('published_on')->nullable();
            $table->boolean('view_in_main')->default(false);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
