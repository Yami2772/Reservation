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
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'read user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        //service_permissions
        Permission::create(['name' => 'create service']);
        Permission::create(['name' => 'read service']);
        Permission::create(['name' => 'update service']);
        Permission::create(['name' => 'delete service']);

        //ROLES
        //Super_Admin
        $Super_Admin = Role::where('name', 'Super_Admin')->exists();
        if (!$Super_Admin) {
            $Super_Admin = Role::create(['name' => 'Super_Admin']);
        }
        //Admin_Role
        $Admin = Role::where('name', 'Admin')->exists();
        if (!$Admin) {
            $Admin = Role::create(['name' => 'Admin']);
        }

        //SYNCING_PERMISSIONS
        $Super_Admin->syncPermissions([
            'create user',
            'read user',
            'update user',
            'delete user',
            'create service',
            'read service',
            'update service',
            'delete service',
        ]);
        $Admin->syncPermissions([
            'create user',
            'read user',
            'update user',
            'delete user',
            'create service',
            'read service',
            'update service',
            'delete service',
        ]);

        //CREATE_USER
        //Super_Admin
        $Super_Admin = User::create([
            'full_name' => 'hesam ardestani',
            'phone_number' => '09036867339',
            'password' => 'hesamam',
        ]);
        $Super_Admin->assignRole('Super_Admin');
        //Admin
        $Admin = User::create([
            'full_name' => 'jojo kuchulu',
            'phone_number' => '09127777777',
            'password' => 'jojoam',
        ]);
        $Admin->assignRole('Admin');
    }
}
