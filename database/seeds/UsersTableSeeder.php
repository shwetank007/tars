<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = [
        	'name'  	=> 'Shwetank Singh',
        	'email' 	=> 'admin@froiden.com',
        	'password'	=>  Hash::make('123456'),
        ];

        User::create($user1);
    }
}
