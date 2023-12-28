<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // IF there is no permission
        if (Permission::count() <=0) {
            // Permission list in array
            $permissions = [
                'admin-dash',
                'user-list', 'user-create', 'user-edit', 'user-delete',
                'permission-list', 'permission-create', 'permission-edit', 'permission-delete',
                'role-list', 'role-create', 'role-edit', 'role-delete',
                'employee-list', 'employee-create', 'employee-edit', 'employee-delete',
            ];
            // Creating permissions
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
