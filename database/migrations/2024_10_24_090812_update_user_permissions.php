<?php
use Illuminate\Support\Facades\DB;
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
        $primaryUsers = DB::table('users')->where('is_primary', 1)->where('user_type', 'client-staff')->get();
        $permissions = [
            'manage_whatsapp', 
            'manage_telegram', 
            'manage_ai_writer', 
            'manage_team', 
            'manage_chat', 
            'manage_campaigns', 
            'manage_ticket', 
            'manage_setting',
            'manage_widget',
            'manage_template',
            'manage_flow',
            'manage_sms_marketing'
        ];
        $userPermissions = json_encode($permissions);
        foreach ($primaryUsers as $user) {
            DB::table('users')->where('id', $user->id)->update(['permissions' => $userPermissions]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Implement rollback logic if needed
    }
};
