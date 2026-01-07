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
        $enumValues = array_keys(config('static_array.custom_input_types'));
        Schema::table('contact_attributes', function (Blueprint $table) use ($enumValues) {
            $table->enum('type', $enumValues)->default($enumValues[0])->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_attributes', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
