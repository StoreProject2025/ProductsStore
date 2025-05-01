<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

       
        $adminRole->givePermissionTo(['view users', 'edit users', 'delete users']);
        $userRole->givePermissionTo('view users');

       
        $admin = \App\Models\User::where('email', 'test@example.com')->first();
        $admin->assignRole('admin');

      
        $user = \App\Models\User::where('email', 'user2@example.com')->first();
        $user->assignRole('user');
    }
}