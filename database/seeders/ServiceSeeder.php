<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => strtoupper('hospitalización'),
                'status' => 1,
            ],
            [
                'name' => strtoupper('uce'),
                'status' => 1,
            ],
            [
                'name' => strtoupper('uci'),
                'status' => 1,
            ],
            [
                'name' => strtoupper('urgencias'),
                'status' => 1,
            ]
        ];

        Service::insert($services);
    }
}
