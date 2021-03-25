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
        User::create([
            'first_name' => 'Patrick',
            'middle_name' => 'Williams',
            'last_name' => 'Policarpio',
            'email' => 'patrickpolicarpio08@gmail.com',
            'password' => bcrypt('011898Policarpio'),
            'user_type' => 1,
            'is_enabled' => true
        ]);
    }
}
