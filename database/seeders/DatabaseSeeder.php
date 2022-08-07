<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
        User::create([
            'name' => 'Hariyadi',
            'email' => 'pharyyady@gmail.com',
            'password' => bcrypt('141312')
        ]);
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@app.com',
            'password' => bcrypt('password')
        ]);
    }
}
