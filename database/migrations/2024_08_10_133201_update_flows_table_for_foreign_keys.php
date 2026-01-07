<?php
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
        Schema::table('flows', function (Blueprint $table) {
            if (!Schema::hasColumn('flows', 'contact_list_id')) {
                $table->unsignedBigInteger('contact_list_id')->nullable()->after('flow_type');
                // $table->foreign('contact_list_id')->references('id')->on('contacts_lists')->onDelete('set null');
            }
            if (!Schema::hasColumn('flows', 'segment_id')) {
                $table->unsignedBigInteger('segment_id')->nullable()->after('contact_list_id');
                $table->foreign('segment_id')->references('id')->on('segments')->onDelete('set null');
            }
            if (!Schema::hasColumn('flows', 'exclude_list_id')) {
                $table->unsignedBigInteger('exclude_list_id')->nullable()->after('segment_id');
                $table->foreign('exclude_list_id')->references('id')->on('contacts_lists')->onDelete('set null');
            }
            if (!Schema::hasColumn('flows', 'exclude_segment_id')) {
                $table->unsignedBigInteger('exclude_segment_id')->nullable()->after('exclude_list_id');
                $table->foreign('exclude_segment_id')->references('id')->on('segments')->onDelete('set null');
            }
        });
        Schema::table('flows', function (Blueprint $table) {
            if (Schema::hasColumn('flows', 'contact_list_ids')) {
                $table->dropColumn('contact_list_ids');
            }
            if (Schema::hasColumn('flows', 'segment_ids')) {
                $table->dropColumn('segment_ids');
            }
            if (Schema::hasColumn('flows', 'exclude_list_ids')) {
                $table->dropColumn('exclude_list_ids');
            }
            if (Schema::hasColumn('flows', 'exclude_segment_ids')) {
                $table->dropColumn('exclude_segment_ids');
            }
        });
    }

    public function down()
    {
        Schema::table('flows', function (Blueprint $table) {
            $table->json('contact_list_ids')->nullable()->after('status');
            $table->json('segment_ids')->nullable()->after('contact_list_ids');
            $table->json('exclude_list_ids')->nullable()->after('segment_ids');
            $table->json('exclude_segment_ids')->nullable()->after('exclude_list_ids');
            if (Schema::hasColumn('flows', 'contact_list_id')) {
                $table->dropForeign(['contact_list_id']);
                $table->dropColumn('contact_list_id');
            }
            if (Schema::hasColumn('flows', 'segment_id')) {
                $table->dropForeign(['segment_id']);
                $table->dropColumn('segment_id');
            }
            if (Schema::hasColumn('flows', 'exclude_list_id')) {
                $table->dropForeign(['exclude_list_id']);
                $table->dropColumn('exclude_list_id');
            }
            if (Schema::hasColumn('flows', 'exclude_segment_id')) {
                $table->dropForeign(['exclude_segment_id']);
                $table->dropColumn('exclude_segment_id');
            }
        });
    }
};
