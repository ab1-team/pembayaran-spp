<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SyncUserPasswords extends Command
{
    protected $signature = 'users:sync-passwords';
    protected $description = 'Set each user password = email';

    public function handle()
    {
        $users = DB::table('users')->get();
        foreach ($users as $u) {
            DB::table('users')->where('id', $u->id)->update([
                'password' => Hash::make($u->email),
            ]);
            $this->line($u->email . ' => updated');
        }
        return 0;
    }
}
