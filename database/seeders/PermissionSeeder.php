<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //PERMISSIONS
        //user_permissions
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'read_user']);
        Permission::create(['name' => 'update_user']);
        Permission::create(['name' => 'delete_user']);
        //service_permissions
        Permission::create(['name' => 'create_service']);
        Permission::create(['name' => 'update_service']);
        Permission::create(['name' => 'delete_service']);
        //reservation_permissions
        Permission::create(['name' => 'create_reservation']);
        Permission::create(['name' => 'read_reservation']);
        Permission::create(['name' => 'update_reservation']);
        Permission::create(['name' => 'delete_reservation']);
        //timing_permissions
        Permission::create(['name' => 'create_timing']);
        Permission::create(['name' => 'read_timing']);
        Permission::create(['name' => 'update_timing']);
        Permission::create(['name' => 'delete_timing']);

        //ROLES
        //Admin_Role
        $Admin = Role::where('name', 'Admin')->exists();
        if (!$Admin) {
            $Admin = Role::create(['name' => 'Admin']);
        }
        $User = Role::where('name', 'User')->exists();
        if (!$User) {
            $User = Role::create(['name' => 'User']);
        }

        //SYNCING_PERMISSIONS
        $Admin->syncPermissions([
            'create_user',
            'read_user',
            'update_user',
            'delete_user',
            'create_service',
            'read_service',
            'update_service',
            'delete_service',
            'create_reservation',
            'read_reservation',
            'update_reservation',
            'delete_reservation',
            'create_timing',
            'read_timing',
            'update_timing',
            'delete_timing',
        ]);
        $User->syncPermissions([
            ''
        ]);

        //CREATE_USERS
        //Admin
        $Admin = User::create([
            'full_name' => 'hesam',
            'phone_number' => '09036867339',
            'password' => 'hesamam',
        ]);
        $Admin->assignRole('Admin');
        //User
        $User = User::create([
            'full_name' => 'jojo',
            'phone_number' => '09127777777',
            'password' => 'jojoam'
        ]);
        $User->assignRole('User');
    }
}
