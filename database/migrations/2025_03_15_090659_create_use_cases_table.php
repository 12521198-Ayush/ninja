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
        Schema::create('use_cases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->text('image');
            $table->string('link');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        // Insert 18 rows of default data
        DB::table('use_cases')->insert([
            [
                'title' => 'Retargetting',
                'description' => '["Retarget your existing customers"]',
                'image' => '{"storage":"local","original_image":"images/seeder/1.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Founders',
                'description' => '["Reach more people & create awareness"]',
                'image' => '{"storage":"local","original_image":"images/seeder/2.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Influencers',
                'description' => '["Build strong community and sale"]',
                'image' => '{"storage":"local","original_image":"images/seeder/3.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Ecommerce stores',
                'description' => '["Scale sales by mass marketing"]',
                'image' => '{"storage":"local","original_image":"images/seeder/4.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Youtubers',
                'description' => '["Increase your video views"]',
                'image' => '{"storage":"local","original_image":"images/seeder/5.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital sellers',
                'description' => '["Sell any digital goods"]',
                'image' => '{"storage":"local","original_image":"images/seeder/6.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Facebook sellers',
                'description' => '["Retarget your factbook customer"]',
                'image' => '{"storage":"local","original_image":"images/seeder/7.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'SME',
                'description' => '["Reach out & start getting first customers"]',
                'image' => '{"storage":"local","original_image":"images/seeder/8.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Enterprises',
                'description' => '["Mass marketing and grow on scale"]',
                'image' => '{"storage":"local","original_image":"images/seeder/9.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Marketers',
                'description' => '["Run marketing campaigns for your agency"]',
                'image' => '{"storage":"local","original_image":"images/seeder/10.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Coaches',
                'description' => '["Sell e-book or courses"]',
                'image' => '{"storage":"local","original_image":"images/seeder/11.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hotels',
                'description' => '["Run promotion on off season for guests"]',
                'image' => '{"storage":"local","original_image":"images/seeder/12.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Restaurants',
                'description' => '["Offer coupons for growing sales"]',
                'image' => '{"storage":"local","original_image":"images/seeder/13.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Flight booking',
                'description' => '["Sell tickets promoting offers"]',
                'image' => '{"storage":"local","original_image":"images/seeder/14.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'SAAS products',
                'description' => '["Launch promotion or get early adopters"]',
                'image' => '{"storage":"local","original_image":"images/seeder/15.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Consultation service',
                'description' => '["Reachout personally and provide services"]',
                'image' => '{"storage":"local","original_image":"images/seeder/16.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Ride sharing',
                'description' => '["Run promotional offers to retain customers"]',
                'image' => '{"storage":"local","original_image":"images/seeder/17.svg"}',
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'And More',
                'description' => '["Use SaleBot for any and every use cases"]',
                'image' => '{"storage":"local","original_image":"images/seeder/18.svg"}',
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
        Schema::dropIfExists('use_cases');
    }
};
