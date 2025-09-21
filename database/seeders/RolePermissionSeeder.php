<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'send.invite',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'candidate' => [],
            'recruiter' => [],
            'admin' => ['send.invite'],
            'super admin' => $permissions
        ];

        foreach ($roles as $role => $perms) {
            $role = Role::create(['name' => $role]);
            $role->givePermissionTo($perms);
        }
    }
}
