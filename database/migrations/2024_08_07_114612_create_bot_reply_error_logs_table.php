<?php

use App\Enums\TypeEnum;
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
    public function up(): void
    {
        if (!Schema::hasTable('bot_reply_error_logs')) {
            Schema::create('bot_reply_error_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('flow_id')->nullable();
                $table->unsignedBigInteger('message_id')->nullable();
                $table->unsignedBigInteger('contact_id')->nullable();
                $table->text('error_message');
                $table->text('error_trace')->nullable();
                $table->string('status_code')->nullable();
                $table->enum('type', [
                    TypeEnum::WHATSAPP->value,
                    TypeEnum::TELEGRAM->value,
                    TypeEnum::MESSENGER->value,
                    TypeEnum::INSTAGRAM->value,
                ])->default(TypeEnum::WHATSAPP->value);
                $table->timestamp('occurred_at')->useCurrent();
                $table->timestamps();
                // Foreign keys
                $table->foreign('flow_id')->references('id')->on('flows')->onDelete('cascade');
                $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
                $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_reply_error_logs');
    }
};
