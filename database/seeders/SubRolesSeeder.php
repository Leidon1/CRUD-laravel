<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubRole;

class SubRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subRoles = [
            ['name' => 'Team Leader', 'role_id' => 1],
            ['name' => 'Senior', 'role_id' => 2],
            ['name' => 'Junior', 'role_id' => 3],
        ];

        // Insert the sub-roles into the database
        SubRole::insert($subRoles);
    }
}
