<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('users')->insertOrIgnore([
            'id'=> '2',
            'name' => 'Roiyall Coffee',
            'email'=> 'roiyall@gmail.com',
            'password'=> Hash::make('roiyall123'),
            'role'=> 'admin',
        ]);
    }
}

