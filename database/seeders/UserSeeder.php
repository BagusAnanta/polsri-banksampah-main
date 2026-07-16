<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'Admin']);

        $user = User::where('email', 'admin@gmail.com')->first();

        if (!$user) {
            $user = new User();
            $user->name = 'Admin';
            $user->username = 'admin';
            $user->email = 'admin@gmail.com';
            $user->password = Hash::make('admin');
            $user->save();

            $user->user_code = 'Admin' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
            $user->save();
        }

        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        if (!$user->hasRole($role->name)) {
            $user->assignRole($role->name);
        }
    }
}
