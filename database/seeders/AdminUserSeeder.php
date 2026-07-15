<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $admins = [
            ['name' => 'Administrator', 'username' => 'admin', 'email' => 'admin@local'],
        ];

        foreach ($admins as $a) {
            if (DB::table('users')->where('username', $a['username'])->exists()) continue;
            DB::table('users')->insert([
                'name' => $a['name'],
                'email' => $a['email'],
                'username' => $a['username'],
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
