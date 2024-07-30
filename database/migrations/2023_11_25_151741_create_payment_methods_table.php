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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('driver_name')->unique();
            

            // For live start 
            $table->string('merchant_email')->nullable(); 
            $table->string('merchant_password')->nullable(); 
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('signature')->nullable();
            // For live end

            // For sandbox start 
            $table->string('sandbox_merchant_email')->nullable(); 
            $table->string('sandbox_merchant_password')->nullable(); 
            $table->string('sandbox_client_id')->nullable();
            $table->string('sandbox_client_secret')->nullable();
            $table->string('sandbox_username')->nullable();
            $table->string('sandbox_password')->nullable();
            $table->string('sandbox_signature')->nullable();
            // For sandbox end
            
            $table->boolean('sandbox')->default(false);
            $table->boolean('status')->default(false);

            // common start 
            $table->dateTime('published_on')->nullable(); 
            $table->string('created_by')->nullable(); 
            $table->string('updated_by')->nullable(); 
            $table->string('deleted_by')->nullable();
            // common end

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
        Schema::dropIfExists('payment_methods');
    }
};
