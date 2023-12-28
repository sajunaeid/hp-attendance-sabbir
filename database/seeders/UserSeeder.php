<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // admin user
        $adminuser = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@app.com',
            'password' => Hash::make('admin123'),
        ]);
        $adminrole = Role::where('name','admin')->first();
        $adminuser->assignRole([$adminrole->id]);


        // manager user
        $manageruser = User::create([
            'name' => 'Manager',
            'email' => 'manager@app.com',
            'password' => Hash::make('manager123'),
        ]);
        $managerrole = Role::where('name','manager')->first();
        $manageruser->assignRole([$managerrole->id]);

    }
}
