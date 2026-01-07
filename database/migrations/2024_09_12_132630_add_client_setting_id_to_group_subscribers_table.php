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
            $table->unsignedBigInteger('client_setting_id')->nullable()->after('id'); // Add the column
            $table->foreign('client_setting_id')->references('id')->on('client_settings')->onDelete('cascade'); // Add foreign key
        });
    }

    public function down()
    {
        Schema::table('group_subscribers', function (Blueprint $table) {
            $table->dropForeign(['client_setting_id']); // Remove foreign key
            $table->dropColumn('client_setting_id'); // Remove column
        });
    }
};
