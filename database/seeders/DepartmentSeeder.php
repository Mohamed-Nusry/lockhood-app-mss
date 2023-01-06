<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert(
            [
                [
                    'name' => "IT",
                    'code' => "dep001",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "Sales & Marketing",
                    'code' => "dep002",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "Purchasing",
                    'code' => "dep003",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "Finance",
                    'code' => "dep004",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "HR",
                    'code' => "dep005",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "R&D",
                    'code' => "dep006",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "Engineering Design",
                    'code' => "dep007",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "Engineering",
                    'code' => "dep008",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
                [
                    'name' => "Factory Management",
                    'code' => "dep009",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-01-06 22:33:48",
                ],
            ]
        );
    }
}
