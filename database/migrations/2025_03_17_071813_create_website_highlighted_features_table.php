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
        Schema::create('website_highlighted_features', function (Blueprint $table) {
            $table->id();
            $table->text('logo');
            $table->string('mini_title');
            $table->string('title');
            $table->longText('description');
            $table->string('lable');
            $table->string('link');
            $table->text('image');
            $table->enum('status', [0, 1])->default(1);
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
        Schema::dropIfExists('website_highlighted_features');
    }
};
