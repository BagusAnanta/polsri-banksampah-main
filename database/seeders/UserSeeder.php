<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin',
                'role' => 'Admin',
                'code_prefix' => 'Admin',
            ],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => 'superadmin',
                'role' => 'Super Admin',
                'code_prefix' => 'SA',
            ],
        ];

        $permissions = Permission::pluck('id', 'id')->all();

        foreach ($users as $userData) {
            $user = User::where('email', $userData['email'])->first();

            if (!$user) {
                $role = Role::firstOrCreate(['name' => $userData['role']]);
                $role->syncPermissions($permissions);

                $user = User::create([
                    'name' => $userData['name'],
                    'username' => $userData['username'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                ]);

                $user->update([
                    'user_code' => $userData['code_prefix'] . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                ]);

                $user->assignRole($userData['role']);
            }
        }
    }
}
