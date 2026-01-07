<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('flows', function (Blueprint $table) {
            if (!Schema::hasColumn('flows', 'keywords')) {
                $table->string('keywords')->nullable()->after('name');
            }
            if (!Schema::hasColumn('flows', 'matching_type')) {
                $table->enum('matching_type', ['exacts', 'contains'])->default('contains')->after('keywords');
            }
        });
        $this->migrateStarterBoxData();
    }

    public function down()
    {
        Schema::table('flows', function (Blueprint $table) {
            if (Schema::hasColumn('flows', 'keywords')) {
                $table->dropColumn('keywords');
            }
            if (Schema::hasColumn('flows', 'matching_type')) {
                $table->dropColumn('matching_type');
            }
        });
    }

    private function migrateStarterBoxData()
    {
        $starterBoxes = DB::table('flow_nodes')
            ->where('type', 'starter-box')
            ->get();
        foreach ($starterBoxes as $node) {
            $data = json_decode($node->data, true);
            if (isset($data['keyword']) && isset($data['matching_types'])) {
                $keywords = $data['keyword'];
                $matchingType = $data['matching_types'];
                DB::table('flows')
                    ->where('id', $node->flow_id)
                    ->update([
                        'keywords' => $keywords,
                        'matching_type' => $matchingType
                    ]);
            }
        }
    }
};
