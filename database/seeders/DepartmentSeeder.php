<?php

namespace Database\Seeders;

use App\Models\MDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MDepartment::create([
            "name"=> "Engineering",
        ]);
        MDepartment::create([
            "name"=> "IT",
        ]);
    }
}
