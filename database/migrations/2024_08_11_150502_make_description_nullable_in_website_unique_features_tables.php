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
        // Making 'description' nullable in 'website_unique_features' table
        Schema::table('website_unique_features', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        // Making 'description' nullable in 'website_unique_feature_languages' table
        Schema::table('website_unique_feature_languages', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverting 'description' to not nullable in 'website_unique_features' table
        Schema::table('website_unique_features', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });

        // Reverting 'description' to not nullable in 'website_unique_feature_languages' table
        Schema::table('website_unique_feature_languages', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });
    }
};
