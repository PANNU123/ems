<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call(UserTableSeeder::class);
       $this->call(RolePermissionTableSeeder::class);
       $this->call(AcademicTypeTableSeeder::class);
       $this->call(SubjectTableSeeder::class);
    }
}
