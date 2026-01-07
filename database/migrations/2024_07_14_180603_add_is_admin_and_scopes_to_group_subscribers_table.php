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
        Schema::table('group_subscribers', function (Blueprint $table) {
            if (!Schema::hasColumn('group_subscribers', 'bot_reply')) {
                $table->string('unique_id',100)->nullable()->after('id')->comment('subscriber id from fb,telegram or others');
            }
            if (!Schema::hasColumn('group_subscribers', 'is_bot')) {
                $table->boolean('is_bot')->default(false)->after('group_id')->comment('');
            }

            if (!Schema::hasColumn('group_subscribers', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('is_bot')->comment('is administrator');
            }
            if (!Schema::hasColumn('group_subscribers', 'scopes')) {
                $table->json('scopes')->nullable()->after('is_admin')->comment('Subscriber access scopes');
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
        Schema::table('group_subscribers', function (Blueprint $table) {
            if (Schema::hasColumn('group_subscribers', 'unique_id')) {
                $table->dropColumn('unique_id');
            }
            if (Schema::hasColumn('group_subscribers', 'is_bot')) {
                $table->dropColumn('is_bot');
            }
            if (Schema::hasColumn('group_subscribers', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
            if (Schema::hasColumn('group_subscribers', 'scopes')) {
                $table->dropColumn('scopes');
            }
        });
    }
};
