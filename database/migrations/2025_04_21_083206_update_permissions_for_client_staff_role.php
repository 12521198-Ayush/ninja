<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $role = DB::table('roles')->where('slug', 'Client-staff')->first();
        if ($role) {
            $permissions = json_decode($role->permissions, true);

            $newPermissions = [
                'manage_messenger',
                'manage_instagram',
            ];

            foreach ($newPermissions as $permission) {
                if (!in_array($permission, $permissions)) {
                    $permissions[] = $permission;
                }
            }

            DB::table('roles')->where('slug', 'Client-staff')->update([
                'permissions' => json_encode($permissions),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $role = DB::table('roles')->where('slug', 'Client-staff')->first();
        if ($role) {
            $permissions = json_decode($role->permissions, true);

            $removePermissions = [
                'manage_messenger',
                'manage_instagram',
            ];

            foreach ($removePermissions as $permission) {
                if (($key = array_search($permission, $permissions)) !== false) {
                    unset($permissions[$key]);
                }
            }

            // Reindex array to remove gaps in keys
            $permissions = array_values($permissions);

            DB::table('roles')->where('slug', 'Client-staff')->update([
                'permissions' => json_encode($permissions),
                'updated_at' => now(),
            ]);
        }
    }
};
