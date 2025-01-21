<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Developer;

class DeveloperSeeder extends Seeder
{
    public function run()
    {
        // Generate 50 developers using the factory
        Developer::factory(50)->create();
    }
}
