<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'content' => json_encode(['permissions' => ['create', 'edit', 'delete']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Editor',
                'content' => json_encode(['permissions' => ['edit', 'publish']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Viewer',
                'content' => json_encode(['permissions' => ['view']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
