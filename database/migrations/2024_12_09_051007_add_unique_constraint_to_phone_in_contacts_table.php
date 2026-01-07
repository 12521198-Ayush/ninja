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
        // Step 1: Remove duplicates for phone and client_id, keeping the first occurrence
        $deletedContacts = DB::table('contacts as c1')
            ->join('contacts as c2', function ($join) {
                $join->on('c1.phone', '=', 'c2.phone')
                     ->on('c1.client_id', '=', 'c2.client_id')
                     ->whereRaw('c1.id > c2.id');
            })
            ->delete();

        // Log the result if duplicates were found and removed
        Log::info($deletedContacts > 0
            ? "{$deletedContacts} duplicate phone entries found for client_id and removed, keeping only the first occurrence."
            : "No duplicate phone entries found for client_id."
        );

        // Step 2: Add the unique constraint on phone and client_id
        try{
            Schema::table('contacts', function (Blueprint $table) {
                $table->unique(['phone', 'client_id'], 'contacts_phone_client_unique');
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
            // Drop the composite unique constraint if necessary
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropUnique('contacts_phone_client_unique');
            });
        } catch (\Exception $e) {
            // Index already exists, do nothing
            Log::info('Unique index not found: ' . $e->getMessage());
        }  
    }
};
