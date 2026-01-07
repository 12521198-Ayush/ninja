<?php

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
        if (!Schema::hasTable('contact_flow_states')) {
            Schema::create('contact_flow_states', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('contact_id');
                $table->unsignedBigInteger('flow_id');
                $table->string('current_node_id', 191);
                $table->boolean('is_end')->default(0);
                $table->timestamp('last_interaction_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamps();
                // $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
                // $table->foreign('flow_id')->references('id')->on('flows')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_flow_states');
    }
};
