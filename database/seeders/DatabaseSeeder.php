<?php

namespace Database\Seeders;

use App\Models\Surveyor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

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
        User::create([
            'name' => 'Dr. Farid Harja',
            'email' => '12345@app.com',
            'password' => bcrypt('12345')
        ]);
        User::create([
            'name' => 'Dr. Fatimah',
            'email' => '123456@app.com',
            'password' => bcrypt('123456')
        ]);

        Artisan::call('passport:install --force');

        Surveyor::create([
            'nama' => 'Dr. Farid Harja',
            'user_id'=>3
        ]);
        Surveyor::create([
            'nama' => 'Dr. Fatimah',
            'user_id'=>4
        ]);
    }
}
