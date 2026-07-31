<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $roles = [
            'Super Admin',
            'Admin',
            'Masyarakat',
            'Admin Bank Sampah',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
