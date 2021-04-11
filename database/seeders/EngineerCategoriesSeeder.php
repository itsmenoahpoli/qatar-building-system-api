<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Engineers\EngineerCategory;

class EngineerCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EngineerCategory::create([
          'name' => 'Architect Engineer', 
          'slug' => 'architect-engineer'
        ]);

        EngineerCategory::create([
          'name' => 'Civil Engineer', 
          'slug' => 'civil-engineer'
        ]);

        EngineerCategory::create([
          'name' => 'Mechanical Engineer', 
          'slug' => 'mechanical-engineer'
        ]);

        EngineerCategory::create([
          'name' => 'Structural Engineer', 
          'slug' => 'structural-engineer'
        ]);

        EngineerCategory::create([
          'name' => 'Electrical Engineer', 
          'slug' => 'electrical-engineer'
        ]);
    }
}
