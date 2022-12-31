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
                'first_name' => "Lockhood",
                'last_name' => "Admin",
                'name' => "sadmin15",
                'email' => "lockhoodadmin@gmail.com",
                'password' => Hash::make('sadmin@123'),
                'user_type' => 1,
                'created_at' => "2022-12-01 22:33:48",
            ]
        );
    }
}
