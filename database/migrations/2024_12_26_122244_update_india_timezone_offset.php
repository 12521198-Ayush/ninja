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
        // Update the timezone offset for India (IN) from 5.50 to 5.30
        DB::table('timezones')
            ->where('country_code', 'IN')
            ->where('timezone', 'Asia/Kolkata')
            ->update([
                'gmt_offset' => 5.30,
                'dst_offset' => 5.30,
                'raw_offset' => 5.30,
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
        // Revert the timezone offset for India (IN) back from 5.30 to 5.50
        DB::table('timezones')
            ->where('country_code', 'IN')
            ->where('timezone', 'Asia/Kolkata')
            ->update([
                'gmt_offset' => 5.50,
                'dst_offset' => 5.50,
                'raw_offset' => 5.50,
                'updated_at' => now(),
            ]);
    }
};
