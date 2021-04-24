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
      // Default SUPERADMIN
      User::create([
          'first_name' => 'SUPERADMIN',
          'middle_name' => 'SUPERADMIN',
          'last_name' => 'SUPERADMIN',
          'email' => 'superadmin.default@domain.com',
          'password' => bcrypt('011898Policarpio'),
          'user_role_id' => 1,
          'is_enabled' => true,
          'is_verified' => true
      ]);

      // Patrick Policarpio
      // User::create([
      //     'first_name' => 'Patrick',
      //     'middle_name' => 'Williams',
      //     'last_name' => 'Policarpio',
      //     'email' => 'patrickpolicarpio08@gmail.com',
      //     'password' => bcrypt('011898Policarpio'),
      //     'user_role_id' => 1,
      //     'is_enabled' => true,
      //     'is_verified' => true
      // ]);
      
      // Aldrin
      User::create([
        'first_name' => 'Aldrin',
        'middle_name' => '',
        'last_name' => 'Alemania',
        'email' => 'a.alemania@e-bpms.site',
        'password' => bcrypt('12345678'),
        'user_role_id' => 1,
        'is_enabled' => true,
        'is_verified' => true
      ]);

      // Rafael
      User::create([
        'first_name' => 'Rafael',
        'middle_name' => '',
        'last_name' => 'Doe',
        'email' => 'rafael@e-bpms.site',
        'password' => bcrypt('12345678'),
        'user_role_id' => 1,
        'is_enabled' => true,
        'is_verified' => true
      ]);

      // Sam
      User::create([
        'first_name' => 'Sam',
        'middle_name' => '',
        'last_name' => 'Doe',
        'email' => 'sam@e-bpms.site',
        'password' => bcrypt('12345678'),
        'user_role_id' => 1,
        'is_enabled' => true,
        'is_verified' => true
      ]);
    }
}
