<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create or get the main branch
        $branch = Branch::firstOrCreate(
            ['name' => 'Main Branch'],
            [
                'location' => 'Davao',
            ]
        );

        // Seed admin only if not existing
        if (!Employee::where('username', 'superadmin')->exists()) {
            Employee::create([
                'branch_id'         => $branch->branch_id,
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'role'              => 'superadmin',
                'phone_number'      => '0923123112',
                'email_address'     => 'superadmin@account.com',
                'username'          => 'superadmin',
                'password'          => Hash::make('bzsuperadmin'),
                'active_status'     => true,
                'created_date'      => Carbon::now(),
                'updated_date'      => Carbon::now(),
                'createdby_id'      => null,
                'updatedby_id'      => null,
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Username: superadmin');
            $this->command->info('Password: bzsuperadmin');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
