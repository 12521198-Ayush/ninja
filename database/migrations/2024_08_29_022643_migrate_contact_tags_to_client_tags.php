<?php

use App\Models\ContactTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
        // Update contact_tags with the new tag_id values
        ContactTag::select('id', 'client_id', 'title', 'contact_id')
            ->distinct()
            ->whereNotNull('title')
            ->orderBy('client_id')
            ->chunkById(100, function ($contactTags) {
                foreach ($contactTags as $contactTag) {
                    $clientId = optional($contactTag->contact)->client_id;
                    if ($clientId) {
                        // Insert into client_tags and get the id
                        $clientTagId = DB::table('client_tags')->insertGetId([
                            'title'      => $contactTag->title,
                            'client_id'  => $clientId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // Update contact_tags with the new tag_id
                        ContactTag::where('title', $contactTag->title)
                            // ->where('client_id', $clientId)
                            ->update([
                                'tag_id' => $clientTagId,
                                'status' => 1
                            ]);
                    }
                }
            });

        // Remove columns from contact_tags
        Schema::table('contact_tags', function (Blueprint $table) {
            $table->dropColumn(['client_id', 'title','created_at','updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Re-add columns to contact_tags
        Schema::table('contact_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('title')->nullable();
        });

        // Revert tag_id updates
        DB::table('contact_tags')->update(['tag_id' => null]);

        // Remove all records from client_tags
        DB::table('client_tags')->truncate();
    }

};
