<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReHashPasswordsSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            // Only re-hash passwords that are not already bcrypt hashes
            if (!str_starts_with($user->password, '$2y$')) {
                DB::table('users')->where('id', $user->id)->update([
                    'password' => Hash::make($user->password),
                ]);
                $this->command->info("Re-hashed password for user: {$user->name}");
            }
        }
        $this->command->info('Done.');
    }
}
