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
            [
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'akses' => 'master',
            ],
        ];

        foreach ($admins as $a) {
            $existing = DB::table('admin_user')->where('email', $a['email'])->first();

            if ($existing) {
                if (! str_starts_with($existing->password, '$2y$') && ! str_starts_with($existing->password, '$2a$')) {
                    DB::table('admin_user')->where('id', $existing->id)->update([
                        'password' => $a['password'],
                        'updated_at' => $now,
                    ]);
                }

                continue;
            }

            DB::table('admin_user')->insert([
                'nama_lengkap' => $a['nama_lengkap'],
                'email' => $a['email'],
                'password' => $a['password'],
                'akses' => $a['akses'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
