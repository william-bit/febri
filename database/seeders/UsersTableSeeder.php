<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => env('INITIAL_USER_NAME'),
            'email' => env('INITIAL_USER_EMAIL'),
            'username' => env('INITIAL_USER_USERNAME'),
            'role_id' => env('INITIAL_USER_ROLE'),
            'password' => env('INITIAL_USER_PASSWORDHASH'),
          ]);
    }
}
