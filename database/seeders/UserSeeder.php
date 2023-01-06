<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'first_name' => "Lockhood",
                    'last_name' => "Admin",
                    'name' => "sadmin15",
                    'email' => "lockhoodadmin@gmail.com",
                    'password' => Hash::make('sadmin@123'),
                    'user_type' => 1,
                    'department_id' => null,
                    'created_at' => "2022-12-01 22:33:48",
                ],
                [
                    'first_name' => "Alex",
                    'last_name' => "Silva",
                    'name' => "alex15",
                    'email' => "alexhead@gmail.com",
                    'password' => Hash::make('alex@123'),
                    'user_type' => 2,
                    'department_id' => null,
                    'created_at' => "2022-12-01 22:33:48",
                ],
                [
                    'first_name' => "Jane",
                    'last_name' => "Catherine",
                    'name' => "jane15",
                    'email' => "janesup@gmail.com",
                    'password' => Hash::make('jane@123'),
                    'department_id' => 1,
                    'user_type' => 3,
                    'created_at' => "2022-12-01 22:33:48",
                ],
                [
                    'first_name' => "Josh",
                    'last_name' => "Wood",
                    'name' => "josh15",
                    'email' => "joshdept@gmail.com",
                    'password' => Hash::make('josh@123'),
                    'user_type' => 4,
                    'department_id' => 1,
                    'created_at' => "2022-12-01 22:33:48",
                ],
                [
                    'first_name' => "Ben",
                    'last_name' => "Almeda",
                    'name' => "ben15",
                    'email' => "benemp@gmail.com",
                    'password' => Hash::make('ben@123'),
                    'user_type' => 5,
                    'department_id' => 1,
                    'created_at' => "2022-12-01 22:33:48",
                ],
              
              
               
            ]
        );
    }
}
