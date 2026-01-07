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
        // Drop the unique constraint from group_chat_id column
        // Schema::table('contacts', function (Blueprint $table) {
        //     $table->dropUnique(['group_chat_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Re-add the unique constraint if needed
        // Schema::table('contacts', function (Blueprint $table) {
        //     $table->unique('group_chat_id');
        // });
    }
};
