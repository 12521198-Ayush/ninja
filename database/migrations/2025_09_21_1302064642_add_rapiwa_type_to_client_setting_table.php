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
        DB::statement("
            ALTER TABLE client_settings 
            MODIFY COLUMN type ENUM(
                'whatsapp', 
                'telegram', 
                'messenger', 
                'instagram', 
                'bigcommerce', 
                'shopify',
                'woocommerce',
                'rapiwa'
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
            ALTER TABLE client_settings 
            MODIFY COLUMN type ENUM(
                'whatsapp', 
                'telegram',
                'messenger',
                'instagram'
            ) DEFAULT 'whatsapp'
        ");
    }
};
