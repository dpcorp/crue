<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'admin.users.index',
            'admin.users.create',
            'admin.users.show',
            'admin.users.edit',

            'admin.roles.index',
            'admin.roles.create',
            'admin.roles.show',
            'admin.roles.edit',

            'admin.ips.index',
            'admin.ips.create',
            'admin.ips.show',
            'admin.ips.edit',

            'admin.occupations.index',
            'admin.occupations.create',
            'admin.occupations.show',

            'admin.out_of_services.index',

            'admin.blockeds.index',

            'admin.saturations.index'
        ];

        User::create([
            'name' => "Administrador",
            'email' => "administrador@ssm.com",
            'email_verified_at' => now(),
            'password' => '!Technor1.', // password
            'rol' => 'Administrador'
        ])->givePermissionTo($permissions);
    }
}
