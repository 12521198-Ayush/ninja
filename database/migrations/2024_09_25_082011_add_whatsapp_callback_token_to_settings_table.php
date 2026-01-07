<?php

use App\Models\Setting;
use Illuminate\Support\Str;
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

    public function down()
    {
        Setting::where('title', 'webhook_verify_token')->delete();
        Setting::where('title', 'webhook_verifed_status')->delete();
    }
};
