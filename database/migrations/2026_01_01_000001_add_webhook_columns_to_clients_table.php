<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('webhook_url')->nullable()->after('api_key');
            $table->boolean('webhook_enabled')->default(false)->after('webhook_url');
            $table->string('webhook_secret')->nullable()->after('webhook_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['webhook_url', 'webhook_enabled', 'webhook_secret']);
        });
    }
};
