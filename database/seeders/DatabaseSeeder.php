<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create(
            [
                'firstname' => 'System',
                'lastname'  => 'Admin',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'email'     => 'admin@email.com',
                'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role'      => 'admin',
                'remember_token' => Str::random(10),
            ]
            );
    }
}
