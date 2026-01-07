<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_flow_builder_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_flow_builder_id')->default(1);
            $table->string('lang');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        // Insert default data after table creation
        DB::table('website_flow_builder_languages')->insert([
            'website_flow_builder_id' => 1,
            'lang' => 'en',
            'title' => 'Flow Builder',
            'description' => '["Create next-level engaging chat flow UI flow bilder"]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_flow_builder_languages');
    }
};
