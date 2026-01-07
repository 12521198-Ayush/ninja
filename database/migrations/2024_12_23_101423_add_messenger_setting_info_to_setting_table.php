<?php

use App\Models\Setting;
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
        if (!Setting::where('title', 'webhook_verify_token')->exists()) {
            Setting::create([
                'title' => 'webhook_verify_token',
                'value' => Str::random(8).now()->format('YmdHis'),
            ]);
        }
        if (!Setting::where('title', 'webhook_verifed_status')->exists()) {
            Setting::create([
                'title' => 'webhook_verifed_status',
                'value' => 0,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting', function (Blueprint $table) {
            //
        });
    }
};
