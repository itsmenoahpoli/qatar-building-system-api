<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Patrick Policarpio
        User::create([
            'first_name' => 'Patrick',
            'middle_name' => 'Williams',
            'last_name' => 'Policarpio',
            'email' => 'patrickpolicarpio08@gmail.com',
            'password' => bcrypt('011898Policarpio'),
            'user_role_id' => 1,
            'is_enabled' => true,
            'is_verified' => true
        ]);
    }
}
