<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_flow_builders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->text('image');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        // Insert default data after table creation
        DB::table('website_flow_builders')->insert([
            'title' => 'Flow Builder',
            'description' => '["Create next-level engaging chat flow UI flow bilder"]',
            'image' => '{"storage":"local","original_image":"images\/seeder\/flow-builder.svg"}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_flow_builders');
    }
};
