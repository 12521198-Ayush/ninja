<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Enums\MessageStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $enumValues = implode("', '", [
            MessageStatusEnum::SCHEDULED->value,
            MessageStatusEnum::SENDING->value,
            MessageStatusEnum::SENT->value,
            MessageStatusEnum::DELIVERED->value,
            MessageStatusEnum::READ->value,
            MessageStatusEnum::FAILED->value,
            MessageStatusEnum::PROCESSING->value, // new status
        ]);

        DB::statement("ALTER TABLE messages MODIFY status 
            ENUM('$enumValues') DEFAULT '" . MessageStatusEnum::SENDING->value . "'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $enumValues = implode("', '", [
            MessageStatusEnum::SCHEDULED->value,
            MessageStatusEnum::SENDING->value,
            MessageStatusEnum::SENT->value,
            MessageStatusEnum::DELIVERED->value,
            MessageStatusEnum::READ->value,
            MessageStatusEnum::FAILED->value,
        ]);

        DB::statement("ALTER TABLE messages MODIFY status 
            ENUM('$enumValues') DEFAULT '" . MessageStatusEnum::SENDING->value . "'");
    }
};
