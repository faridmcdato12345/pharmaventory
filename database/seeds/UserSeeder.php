<?php

use Carbon\Carbon;
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
            'username' => 'cogiemcdato',
            'email' => 'cogiemcdato@gmail.com',
            'password' => Hash::make('Cogiemcd42'),
            'status'=>0,
            'role_id' => 1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        DB::table('users')->insert([
            'username' => 'faridmcdato',
            'email' => 'faridmcdato@gmail.com',
            'password' => Hash::make('Cogiemcd42'),
            'status'=>0,
            'role_id' => 0,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
    }
}
