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
        // Role name list
        $rolenames = [
            'admin',
            'manager',
        ];

        // Creating roles and assigning permission
        foreach ($rolenames as $rolename) {
            $role = Role::create(['name' => $rolename]);
        }

        $permissions = Permission::pluck('id','id')->all();
        $adminRole = Role::where('name','admin')->first();
        $adminRole->syncPermissions($permissions);




    }
}
