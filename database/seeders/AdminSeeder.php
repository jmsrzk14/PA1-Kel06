<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'id'=> '1',
            'name' => 'James Frans Rizky Tambunan',
            'email'=> 'jmsrizky123@gmail.com',
            'password'=> Hash::make('james123'),
            'role'=> 'owner',
        ]);
    }
}

