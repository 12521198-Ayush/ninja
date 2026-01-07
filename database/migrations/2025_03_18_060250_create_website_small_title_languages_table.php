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
        Schema::create('website_small_title_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_small_title_id')->default(1);
            $table->string('lang');
            $table->string('section');
            $table->string('title');
            $table->timestamps();
        });

        // Insert default data after table creation
        DB::table('website_small_title_languages')->insert([
            [
                'website_small_title_id' => 1,
                'lang' => 'en',
                'section' => 'Hero Section',
                'title' => 'Meta Compliant Software',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_small_title_id' => 2,
                'lang' => 'en',
                'section' => 'Features Section',
                'title' => 'Features',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_small_title_id' => 3,
                'lang' => 'en',
                'section' => 'Advantages Section',
                'title' => 'Advantages',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_small_title_id' => 4,
                'lang' => 'en',
                'section' => 'Chat Flow Section',
                'title' => 'Chat Flows',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_small_title_id' => 5,
                'lang' => 'en',
                'section' => 'Pricing Section',
                'title' => 'Pricing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_small_title_id' => 6,
                'lang' => 'en',
                'section' => 'FAQ Section',
                'title' => 'FAQ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_small_title_languages');
    }
};
