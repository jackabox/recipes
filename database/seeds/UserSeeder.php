<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jack Whiting',
            'username' => 'jackabox',
            'email' => 'hi@jackwhiting.co.uk',
            'password' => Hash::make('secret'),
            'remember_token' => str_random(10)
        ]);
    }
}
