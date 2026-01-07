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
        // Check if the table does not exist
        if (!Schema::hasTable('client_setting_details')) {
            Schema::create('client_setting_details', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('client_setting_id');
                $table->string('verified_name', 191)->nullable();
                $table->string('phone_number_id', 191)->nullable();
                $table->string('display_phone_number', 191)->nullable();
                $table->string('name_status', 191)->nullable();
                $table->string('certificate', 191)->nullable();
                $table->string('new_certificate', 191)->nullable();
                $table->string('quality_rating', 191)->nullable();
                $table->string('code_verification_status', 255)->nullable();
                $table->integer('messaging_limit_tier')->nullable();
                $table->string('number_status', 100)->nullable();
                $table->text('profile_info')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
    
                // Define foreign key constraint
                $table->foreign('client_setting_id')
                    ->references('id')
                    ->on('client_settings')
                    ->onDelete('cascade');
            });
        }
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_setting_details');
    }
};
