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
        Schema::create('page_variables', function (Blueprint $table) {
            $table->id();
            $table->string('pv_name')->nullable();
            $table->string('pv_question')->nullable();
            $table->string('pv_type')->nullable();
            $table->boolean('pv_required')->nullable()->default(true);
            $table->string('pv_details')->nullable();
            $table->foreignId('page_group_id')->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('page_variables');
    }
};
