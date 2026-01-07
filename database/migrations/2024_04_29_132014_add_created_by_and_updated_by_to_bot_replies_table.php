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
        Schema::table('bot_replies', function (Blueprint $table) {
            if (!Schema::hasColumn('bot_replies', 'status')) {
                $table->boolean('status')->default(1);
            }
            if (!Schema::hasColumn('bot_replies', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');            
            }

            if (!Schema::hasColumn('bot_replies', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            }
          
            // $table->unique(['name', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bot_replies', function (Blueprint $table) {
            $table->dropUnique(['name', 'client_id']);
            $table->dropColumn(['created_by', 'updated_by']);
        });
    }
};
