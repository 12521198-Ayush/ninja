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
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'is_enable_ai_reply')) {
                $table->boolean('is_enable_ai_reply')->default(false)->after('open_ai_key');
            }
            if (Schema::hasColumn('clients', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if (Schema::hasColumn('clients', 'last_name')) {
                $table->dropColumn('last_name');
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
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'is_enable_ai_reply')) {
                $table->dropColumn('is_enable_ai_reply');
            }
            if (!Schema::hasColumn('clients', 'first_name')) {
                $table->string('first_name')->nullable()->after('id');
            }

            if (!Schema::hasColumn('clients', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
        });
    }
};
