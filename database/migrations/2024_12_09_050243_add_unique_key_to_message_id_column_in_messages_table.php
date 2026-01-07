<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // Step 1: Remove duplicates for message_id and client_id, keeping the first occurrence
        $deletedMessages = DB::table('messages as m1')
            ->join('messages as m2', function ($join) {
                $join->on('m1.message_id', '=', 'm2.message_id')
                     ->on('m1.client_id', '=', 'm2.client_id')
                     ->whereRaw('m1.id > m2.id');
            })
            ->delete();

        // Step 2: Log the result if duplicates were found and removed
        Log::info($deletedMessages > 0 
            ? "{$deletedMessages} duplicate message entries found and removed, keeping only the first occurrence."
            : "No duplicate message entries found for message_id and client_id."
        );

         // Step 2: Add a unique constraint to prevent future duplicates
         try{
            Schema::table('messages', function (Blueprint $table) {
                $table->unique(['message_id', 'client_id'], 'unique_message_client');
            });
        } catch (\Exception $e) {
            // Index already exists, do nothing
            Log::info('Unique index already exists: ' . $e->getMessage());
        }  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            Schema::table('messages', function (Blueprint $table) {
                // Drop the unique constraint
                $table->dropUnique('unique_message_client');
            });
        } catch (\Exception $e) {
            // Index already exists, do nothing
            Log::info('Unique index not found: ' . $e->getMessage());
        }  
    }
};
