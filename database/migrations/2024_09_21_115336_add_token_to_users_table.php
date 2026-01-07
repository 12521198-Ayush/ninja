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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'token')) {
                $table->string('token', 100)->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'token_valid_until')) {
                $table->timestamp('token_valid_until')->nullable()->after('token');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'token')) {
                $table->dropColumn('token');
            }

            if (Schema::hasColumn('users', 'token_valid_until')) {
                $table->dropColumn('token_valid_until');
            }
        });
    }
};
