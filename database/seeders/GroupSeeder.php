<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => strtoupper('adultos'),
                'status' => 1,
            ],
            [
                'name' => strtoupper('ginecobstetricia'),
                'status' => 1,
            ],
            [
                'name' => strtoupper('neonato'),
                'status' => 1,
            ],
            [
                'name' => strtoupper('pediatría'),
                'status' => 1,
            ]
        ];

        Group::insert($groups);
    }
}
