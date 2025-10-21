<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create or get the main branch
        $branch = Branch::firstOrCreate(
            ['name' => 'Main Branch'],
            [
                'location' => 'Davao',
            ]
        );

        // Generate unique random 5-digit employee ID
        do {
            $employee_id = random_int(10000, 99999);
        } while (Employee::where('employee_id', $employee_id)->exists());

        // Seed admin only if not existing
        if (!Employee::where('username', 'admin')->exists()) {
            Employee::create([
                'employee_id'       => $employee_id, 
                'branch_id'         => $branch->branch_id,
                'first_name'        => 'Manager',
                'last_name'         => 'Admin',
                'role'              => 'admin',
                'phone_number'      => '09123123112',
                'email_address'     => 'admin@account.com',
                'username'          => 'admin',
                'password'          => Hash::make('bzadmin'),
                'active_status'     => true,
                'created_date'      => Carbon::now(),
                'updated_date'      => Carbon::now(),
                'createdby_id'      => null,
                'updatedby_id'      => null,
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Username: admin');
            $this->command->info('Password: bzadmin');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
