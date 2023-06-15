<?php

namespace Database\Seeders;

use App\Models\Admin\AcademicType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicType::create([
           'academic_type_name'=>'BCS',
            'academic_type_slug' =>slug('BCS'),
        ]);
    }

}
