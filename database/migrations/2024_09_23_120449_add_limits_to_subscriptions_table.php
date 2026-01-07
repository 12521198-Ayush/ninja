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
            if (!Schema::hasColumn('subscriptions', 'max_chatwidget')) {
                $table->integer('max_chatwidget')->default(0)->after('team_limit');
            }
            if (!Schema::hasColumn('subscriptions', 'max_flow_builder')) {
                $table->integer('max_flow_builder')->default(0)->after('max_chatwidget');
            }
            if (!Schema::hasColumn('subscriptions', 'max_bot_reply')) {
                $table->integer('max_bot_reply')->default(0)->after('max_flow_builder');
            }
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
            if (Schema::hasColumn('subscriptions', 'max_chatwidget')) {
                $table->dropColumn('max_chatwidget');
            }
            if (Schema::hasColumn('subscriptions', 'max_flow_builder')) {
                $table->dropColumn('max_flow_builder');
            }
            if (Schema::hasColumn('subscriptions', 'max_bot_reply')) {
                $table->dropColumn('max_bot_reply');
            }
        });
    }
};
