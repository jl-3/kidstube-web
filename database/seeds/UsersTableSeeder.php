<?php

use Illuminate\Database\Seeder;
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
        User::create([
            'name' => 'Тима Скляр',
            'email' => 'a.m.sklyar@gmail.com',
            'password' => bcrypt('Nodvoghod4'),
            'active' => true
        ]);
    }
}
