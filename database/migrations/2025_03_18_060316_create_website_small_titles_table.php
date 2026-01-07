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
        Schema::create('website_small_titles', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('title');
            $table->text('image');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        // Insert 6 rows of default data
        DB::table('website_small_titles')->insert([
            [
                'section' => 'Hero Section',
                'title' => 'Meta Compliant Software',
                'image' => '{"storage":"local","original_image":"images/seeder/meta-icon.svg"}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'Features Section',
                'title' => 'Features',
                'image' => '{"storage":"local","original_image":"images/seeder/advantage-icon.svg"}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'Advantages Section',
                'title' => 'Advantages',
                'image' => '{"storage":"local","original_image":"images/seeder/advantage-icon.svg"}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'Chat Flow Section',
                'title' => 'Chat Flows',
                'image' => '{"storage":"local","original_image":"images/seeder/flow-icon.svg"}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'Pricing Section',
                'title' => 'Pricing',
                'image' => '{"storage":"local","original_image":"images/seeder/faq-icon.svg"}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'FAQ Section',
                'title' => 'FAQ',
                'image' => '{"storage":"local","original_image":"images/seeder/faq-icon.svg"}',
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
        Schema::dropIfExists('website_small_titles');
    }
};
