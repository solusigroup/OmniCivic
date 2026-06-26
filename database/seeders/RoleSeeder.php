<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define common roles
        $roles = [
            'super_admin',
            'ketua',
            'bendahara',
            'staff',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Define permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage assets',
            'manage journals',
            'approve journals',
            'review journals',
            'view audit logs'
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        
        // Super Admin gets all permissions
        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }

        // Ketua
        $ketua = Role::where('name', 'ketua')->first();
        if ($ketua) {
            $ketua->syncPermissions(['manage journals', 'approve journals', 'manage assets']);
        }

        // Bendahara
        $bendahara = Role::where('name', 'bendahara')->first();
        if ($bendahara) {
            $bendahara->syncPermissions(['manage journals', 'review journals', 'manage assets']);
        }

        // Staff (Operator)
        $staff = Role::where('name', 'staff')->first();
        if ($staff) {
            $staff->syncPermissions(['manage journals', 'manage assets']);
        }
    }
}
