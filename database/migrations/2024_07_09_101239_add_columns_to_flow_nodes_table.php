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
        Schema::table('flow_nodes', function (Blueprint $table) {
            $table->json('connections')->nullable()->after('data');
            $table->unsignedBigInteger('client_id')->nullable()->after('connections');
            $table->unsignedBigInteger('created_by')->nullable()->after('client_id');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            // If you want to add foreign keys
            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flow_nodes', function (Blueprint $table) {
            $table->dropColumn('connections');
            $table->dropColumn('client_id');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            // If you added foreign keys
            // $table->dropForeign(['client_id']);
            // $table->dropForeign(['created_by']);
            // $table->dropForeign(['updated_by']);
        });
    }
};
