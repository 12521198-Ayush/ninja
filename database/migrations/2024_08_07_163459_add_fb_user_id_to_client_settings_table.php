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
    public function up(): void
    {
        Schema::table('client_settings', function (Blueprint $table) {
        if (!Schema::hasColumn('client_settings', 'fb_user_id')) {
            $table->string('fb_user_id')->nullable()->after('expires_at');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_settings', function (Blueprint $table) {
            $table->dropColumn('fb_user_id');
        });
    }
};
