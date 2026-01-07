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
        Schema::create('website_nav_mores', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->text('image');
            $table->string('link');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        // Insert 7 rows of default data
        DB::table('website_nav_mores')->insert([
            [
                'title' => 'Features',
                'description' => '["All the features you need to grow"]',
                'image' => '{"storage":"local","original_image":"images/seeder/19.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'FAQ',
                'description' => '["Frequently Asked Questions"]',
                'image' => '{"storage":"local","original_image":"images/seeder/20.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Documentations',
                'description' => '["Get started with SaleBot"]',
                'image' => '{"storage":"local","original_image":"images/seeder/21.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Blogs',
                'description' => '["All the features you need to grow"]',
                'image' => '{"storage":"local","original_image":"images/seeder/22.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Roadmaps',
                'description' => '["Check your upcoming features"]',
                'image' => '{"storage":"local","original_image":"images/seeder/23.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Upcoming Updates',
                'description' => '["Let’s find out future facilities"]',
                'image' => '{"storage":"local","original_image":"images/seeder/24.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Community',
                'description' => '["Connect with big network"]',
                'image' => '{"storage":"local","original_image":"images/seeder/25.svg"}',
                'link' => '#',
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
        Schema::dropIfExists('website_nav_mores');
    }
};
