<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SystemUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      // Engineers
      User::create([
        'first_name' => 'Civil',
        'middle_name' => '',
        'last_name' => 'Engineer',
        'email' => 'civil@e-bpmps.site',
        'password' => bcrypt('password12345'),
        'user_role_id' => 7,
        'is_enabled' => true,
        'is_verified' => true
      ]);

      User::create([
        'first_name' => 'Mechanical',
        'middle_name' => '',
        'last_name' => 'Engineer',
        'email' => 'mechanical@e-bpmps.site',
        'password' => bcrypt('password12345'),
        'user_role_id' => 7,
        'is_enabled' => true,
        'is_verified' => true
      ]);

      User::create([
        'first_name' => 'Electrical',
        'middle_name' => '',
        'last_name' => 'Engineer',
        'email' => 'electrical@e-bpmps.site',
        'password' => bcrypt('password12345'),
        'user_role_id' => 7,
        'is_enabled' => true,
        'is_verified' => true
      ]);

      User::create([
        'first_name' => 'Architect',
        'middle_name' => '',
        'last_name' => 'Engineer',
        'email' => 'architect@e-bpmps.site',
        'password' => bcrypt('password12345'),
        'user_role_id' => 7,
        'is_enabled' => true,
        'is_verified' => true
      ]);
    }
}
