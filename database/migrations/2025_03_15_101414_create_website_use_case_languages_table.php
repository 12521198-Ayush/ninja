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
        Schema::create('website_use_case_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('use_case_id');
            $table->string('lang');
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
        });

        // Insert 18 rows of default data
        DB::table('website_use_case_languages')->insert([
            [
                'use_case_id' => 1,
                'lang' => 'en',
                'title' => 'Retargetting',
                'description' => '["Retarget your existing customers"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 2,
                'lang' => 'en',
                'title' => 'Founders',
                'description' => '["Reach more people & create awareness"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 3,
                'lang' => 'en',
                'title' => 'Influencers',
                'description' => '["Build strong community and sale"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 4,
                'lang' => 'en',
                'title' => 'Ecommerce stores',
                'description' => '["Scale sales by mass marketing"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 5,
                'lang' => 'en',
                'title' => 'Youtubers',
                'description' => '["Increase your video views"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 6,
                'lang' => 'en',
                'title' => 'Digital sellers',
                'description' => '["Sell any digital goods"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 7,
                'lang' => 'en',
                'title' => 'Facebook sellers',
                'description' => '["Retarget your factbook customer"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 8,
                'lang' => 'en',
                'title' => 'SME',
                'description' => '["Reach out & start getting first customers"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 9,
                'lang' => 'en',
                'title' => 'Enterprises',
                'description' => '["Mass marketing and grow on scale"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 10,
                'lang' => 'en',
                'title' => 'Marketers',
                'description' => '["Run marketing campaigns for your agency"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 11,
                'lang' => 'en',
                'title' => 'Coaches',
                'description' => '["Sell e-book or courses"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 12,
                'lang' => 'en',
                'title' => 'Hotels',
                'description' => '["Run promotion on off season for guests"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 13,
                'lang' => 'en',
                'title' => 'Restaurants',
                'description' => '["Offer coupons for growing sales"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 14,
                'lang' => 'en',
                'title' => 'Flight booking',
                'description' => '["Sell tickets promoting offers"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 15,
                'lang' => 'en',
                'title' => 'SAAS products',
                'description' => '["Launch promotion or get early adopters"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 16,
                'lang' => 'en',
                'title' => 'Consultation service',
                'description' => '["Reachout personally and provide services"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 17,
                'lang' => 'en',
                'title' => 'Ride sharing',
                'description' => '["Run promotional offers to retain customers"]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'use_case_id' => 18,
                'lang' => 'en',
                'title' => 'And More',
                'description' => '["Use SaleBot for any and every use cases"]',
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
        Schema::dropIfExists('website_use_case_languages');
    }
};
