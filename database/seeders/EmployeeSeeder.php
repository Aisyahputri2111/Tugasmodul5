<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'firstname' => 'Aisyah',
                'lastname' => 'Putri',
                'email'=> 'aisyahamni21@gmail.com',
                'age' => 20,
                'position_id' => 1
            ],
            [
                'firstname' => 'Febryanto',
                'lastname' => 'Kohar',
                'email'=> 'febryantokohar@gmail.com',
                'age' => 19,
                'position_id' => 2
            ],
            [
                'firstname' => 'Muhammad',
                'lastname' => 'Rasya',
                'email'=> 'muhammadrasya@gmail.com',
                'age' => 16,
                'position_id' => 3
            ],
        ]);
    }
}

