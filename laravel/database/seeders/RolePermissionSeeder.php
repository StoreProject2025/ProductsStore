<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'purchase products']);
        Permission::create(['name' => 'edit profile']);
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'manage stock']);
        Permission::create(['name' => 'moderate reviews']);

        // Create Roles and Assign Permissions
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(['manage products', 'manage users', 'view reports', 'manage roles']);

        $employee = Role::create(['name' => 'Employee']);
        $employee->givePermissionTo(['manage products', 'view reports']);

        $customer = Role::create(['name' => 'Customer']);
        $customer->givePermissionTo(['purchase products', 'edit profile']);

        $supplier = Role::create(['name' => 'Supplier']);
        $supplier->givePermissionTo(['manage stock']);

        $moderator = Role::create(['name' => 'Moderator']);
        $moderator->givePermissionTo(['moderate reviews']);
    }
}