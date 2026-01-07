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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('contact_limit')->change();
            $table->integer('campaign_limit')->change();
            $table->integer('conversation_limit')->change();
            $table->integer('team_limit')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Revert back to unsignedBigInteger
            $table->unsignedBigInteger('contact_limit')->change();
            $table->unsignedBigInteger('campaign_limit')->change();
            $table->unsignedBigInteger('conversation_limit')->change();
            $table->unsignedBigInteger('team_limit')->change();
        });
    }
};
