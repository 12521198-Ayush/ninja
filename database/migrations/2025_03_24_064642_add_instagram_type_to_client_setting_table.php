<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify the 'type' column to include the new value
        DB::statement("
            ALTER TABLE client_settings 
            MODIFY COLUMN type ENUM(
                'whatsapp', 
                'telegram', 
                'messenger', 
                'instagram'
            ) DEFAULT 'whatsapp'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert back to the original enum values without 'instagram'
        DB::statement("
            ALTER TABLE client_settings 
            MODIFY COLUMN type ENUM(
                'whatsapp', 
                'telegram',
                'messenger'
            ) DEFAULT 'whatsapp'
        ");
    }
};
