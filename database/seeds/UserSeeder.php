<?php


use Carbon\Carbon;
use Illuminate\Support\Str;
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
            'status'=>1,
            'role_id' => 2,
            'api_token' => Str::random(32),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        DB::table('users')->insert([
            'username' => 'faridmcdato',
            'email' => 'faridmcdato@gmail.com',
            'password' => Hash::make('Cogiemcd42'),
            'status'=>1,
            'role_id' => 1,
            'api_token'=>Str::random(40),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
    }
}
