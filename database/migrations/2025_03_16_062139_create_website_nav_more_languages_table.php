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
        Schema::create('website_nav_more_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_nav_more_id');
            $table->string('lang');
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
        });

        // Insert 7 rows of default data
        DB::table('website_nav_more_languages')->insert([
            [
                'website_nav_more_id' => 1,
                'lang' => 'en',
                'title' => 'Features',
                'description' => '["All the features you need to grow"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_nav_more_id' => 2,
                'lang' => 'en',
                'title' => 'FAQ',
                'description' => '["Frequently Asked Questions"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_nav_more_id' => 3,
                'lang' => 'en',
                'title' => 'Documentations',
                'description' => '["Get started with SaleBot"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_nav_more_id' => 4,
                'lang' => 'en',
                'title' => 'Blogs',
                'description' => '["All the features you need to grow"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_nav_more_id' => 5,
                'lang' => 'en',
                'title' => 'Roadmaps',
                'description' => '["Check your upcoming features"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_nav_more_id' => 6,
                'lang' => 'en',
                'title' => 'Upcoming Updates',
                'description' => '["Let’s find out future facilities"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'website_nav_more_id' => 7,
                'lang' => 'en',
                'title' => 'Community',
                'description' => '["Connect with big network"]',
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
        Schema::dropIfExists('website_nav_more_languages');
    }
};
