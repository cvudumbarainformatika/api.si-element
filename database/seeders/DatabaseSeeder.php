<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // \App\Models\User::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'farhan',
            'email' => 'faran.f4124n@gmail.com',
            'password' => bcrypt('123456'),
            'status' => 'aktif',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'wawan',
            'email' => 'wawan@app.com',
            'password' => bcrypt('123456'),
            'status' => 'aktif',
            'role' => 'root'
        ]);

        $this->call([
            SettingSeeder::class
        ]);
    }
}
