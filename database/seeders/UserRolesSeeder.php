<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Full access roles
        UserRole::create([
            'name' => 'admin',
            'title' => 'Admin'
        ]);

        UserRole::create([
            'name' => 'executive-level',
            'title' => 'Executive Level'
        ]);

        UserRole::create([
            'name' => 'middle-manager',
            'title' => 'Middle Manager'
        ]);

        // Mid access roles
        UserRole::create([
            'name' => 'staff-technical',
            'title' => 'Staff Technical'
        ]);

        // Low access roles
        UserRole::create([
            'name' => 'staff-financial',
            'title' => 'Staff Financial'
        ]);

        // End access roles
        UserRole::create([
            'name' => 'client',
            'title' => 'Client'
        ]);
    }
}
