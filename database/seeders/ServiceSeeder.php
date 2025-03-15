<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::create([
            'name' => 'PlayStation 4',
            'price' => 30000,
        ]);
        
        Service::create([
            'name' => 'PlayStation 5',
            'price' => 40000,
        ]);
    }
}