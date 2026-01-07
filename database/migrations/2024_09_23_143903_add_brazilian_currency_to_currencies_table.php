<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('currencies')->insert([
            'name' => 'Brazilian Real',
            'symbol' => 'R$',
            'code' => 'BRL',
            'exchange_rate' => 5.20,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('currencies')->where('code', 'BRL')->delete();
    }
    
};
