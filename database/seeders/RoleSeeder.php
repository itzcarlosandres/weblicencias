<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage-products',
            'manage-categories',
            'manage-brands',
            'manage-licenses',
            'manage-orders',
            'manage-users',
            'manage-coupons',
            'manage-tickets',
            'manage-blog',
            'manage-settings',
            'view-dashboard',
            'manage-reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo($permissions);

        $moderator = Role::create(['name' => 'moderator']);
        $moderator->givePermissionTo([
            'manage-products',
            'manage-categories',
            'manage-licenses',
            'manage-orders',
            'manage-tickets',
            'view-dashboard',
            'manage-reviews',
        ]);

        $user = Role::create(['name' => 'user']);
    }
}
