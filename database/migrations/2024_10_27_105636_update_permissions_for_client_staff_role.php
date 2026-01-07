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
        $role = DB::table('roles')->where('slug', 'Client-staff')->first();
        if ($role) {
            $permissions = json_decode($role->permissions, true);
            if (!in_array('manage_sms_marketing', $permissions)) {
                $permissions[] = 'manage_sms_marketing';
            }
            DB::table('roles')->where('slug', 'Client-staff')->update([
                'permissions' => json_encode($permissions),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        $role = DB::table('roles')->where('slug', 'Client-staff')->first();
        if ($role) {
            $permissions = json_decode($role->permissions, true);
            if (($key = array_search('manage_sms_marketing', $permissions)) !== false) {
                unset($permissions[$key]);
            }
            DB::table('roles')->where('slug', 'Client-staff')->update([
                'permissions' => json_encode($permissions),
                'updated_at' => now(),
            ]);
        }
    }
};
