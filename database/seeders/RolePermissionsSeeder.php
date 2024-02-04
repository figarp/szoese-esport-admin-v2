<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Alapértelmezett jogosultságok beszúrása az alapértelmezett szerepekhez
        DB::table('role_permissions')->insert([
            // Admin (1)
            ['role_id' => 1, 'permission_id' => 1], // create_group
            ['role_id' => 1, 'permission_id' => 2], // edit_group
            ['role_id' => 1, 'permission_id' => 3], // delete_group
            ['role_id' => 1, 'permission_id' => 4], // manage_group_members

            // Vezetoseg (2)
            ['role_id' => 2, 'permission_id' => 1], // create_group
            ['role_id' => 2, 'permission_id' => 2], // edit_group
            ['role_id' => 2, 'permission_id' => 3], // delete_group
            ['role_id' => 2, 'permission_id' => 4], // manage_group_members

            // Csoportvezetok (3)
            ['role_id' => 3, 'permission_id' => 2], // edit_group
            ['role_id' => 3, 'permission_id' => 4], // manage_group_members

            // Tagok (4)

            // Vendégek (5)
            ['role_id' => 5, 'permission_id' => 5], // join_group
            ['role_id' => 5, 'permission_id' => 6], // leave_group
        ]);
    }
}