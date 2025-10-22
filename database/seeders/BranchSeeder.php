<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            ['name' => 'Main Branch', 'location' => 'Davao'],
            ['name' => 'Koronadal', 'location' => 'Koronadal City'],
            ['name' => 'Gensan', 'location' => 'General Santos'],
        ];

        foreach ($branches as $b) {
            Branch::firstOrCreate(
                ['name' => $b['name'], 'location' => $b['location']],
                ['name' => $b['name'], 'location' => $b['location']]
            );
        }
    }
}
