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
        Schema::table('contact_tags', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_tags', 'tag_id')) {
                $table->unsignedBigInteger('tag_id')->nullable()->after('contact_id');
            }
            if (!Schema::hasColumn('contact_tags', 'tag_id') && Schema::hasTable('client_tags')) {
                $table->foreign('tag_id')->references('id')->on('client_tags')->onDelete('cascade');
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
        Schema::table('contact_tags', function (Blueprint $table) {
            if (Schema::hasColumn('contact_tags', 'tag_id')) {
                $table->dropForeign(['tag_id']);
            }
            if (Schema::hasColumn('contact_tags', 'tag_id')) {
                $table->dropColumn('tag_id');
            }
        });
    }
};
