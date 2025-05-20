<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //! Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        //! Create permissions
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'read']);
        Permission::create(['name' => 'update']);
        Permission::create(['name' => 'delete']);

        $admin = Role::findByName('admin');
        $admin->syncPermissions(Permission::all());
        
        $user = Role::findByName('user');
        $user->syncPermissions(['read']);

    }
}
