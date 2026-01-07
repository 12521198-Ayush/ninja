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
        // Make message_id nullable for the initial campaign storage
        Schema::table('messages', function (Blueprint $table) {
            $table->string('message_id', 150)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert message_id back to NOT NULL if required
        Schema::table('messages', function (Blueprint $table) {
            $table->string('message_id', 150)->nullable(false)->change();
        });
    }
};
