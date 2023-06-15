<?php

namespace Database\Seeders;

use App\Models\Admin\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'academic_id'=>1,
            'subject_name' => 'English',
            'subject_slug'=>slug('English'),
            'status'=>'active'
        ]);
    }
}
