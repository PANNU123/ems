<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'Sajjad Hossain',
            'email' => 'superadmin@gmail.com',
            'image' =>  'sajjad.jpg',
            'phone_number'=>1796234234,
            'gender'=>'male',
            'street_address'=>'Home# 30,Road# 3, Mirpur-12,Dhaka-1216,Bangladesh',
            'about'=>'Designing and implementing applications that are written in PHP',
            'dob'=>Carbon::parse('1999-10-30'),
            'password' => Hash::make('password'),
        ]);
    }
}
