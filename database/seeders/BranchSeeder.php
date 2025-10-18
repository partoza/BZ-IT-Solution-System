<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        // Prevent duplicate seeding
        if (! Branch::where('name', 'Main Branch')->where('location', 'Davao')->exists()) {
            Branch::create([
                'name'     => 'Main Branch',
                'location' => 'Davao',
            ]);
        }
    }
}
