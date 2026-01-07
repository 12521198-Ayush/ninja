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
        Schema::create('website_highlighted_feature_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_highlighted_feature_id');
            $table->string('lang');
            $table->string('mini_title');
            $table->string('title');
            $table->longText('description');
            $table->string('lable');
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
        Schema::dropIfExists('website_highlighted_feature_languages');
    }
};
