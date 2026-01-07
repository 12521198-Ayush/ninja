<?php
use App\Models\Campaign;
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
        // Add new columns if they don't exist
        Schema::table('campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('campaigns', 'contact_list_ids')) {
                $table->json('contact_list_ids')->nullable();
            }
            if (!Schema::hasColumn('campaigns', 'segment_ids')) {
                $table->json('segment_ids')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('campaigns', 'contact_list_ids')) {
                $table->dropColumn('contact_list_ids');
            }
            if (Schema::hasColumn('campaigns', 'segment_ids')) {
                $table->dropColumn('segment_ids');
            }
        });
    }
};
