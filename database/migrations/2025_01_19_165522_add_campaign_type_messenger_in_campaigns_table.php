<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement("
            ALTER TABLE campaigns 
            MODIFY COLUMN campaign_type ENUM(
                'whatsapp', 
                'telegram', 
                'messenger'
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
        DB::statement("
            ALTER TABLE campaigns 
            MODIFY COLUMN campaign_type ENUM(
                'whatsapp', 
                'telegram'
            ) DEFAULT 'whatsapp'
        ");
    }
};
