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
        Schema::table('flows', function (Blueprint $table) {
            $table->json('exclude_list_ids')->nullable()->after('contact_list_ids');
            $table->json('exclude_segment_ids')->nullable()->after('segment_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flows', function (Blueprint $table) {
            $table->dropColumn('exclude_list_ids');
            $table->dropColumn('exclude_segment_ids');
        });
    }
};
