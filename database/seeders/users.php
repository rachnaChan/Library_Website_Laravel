<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'username' => 'rachnac',
            'email' => 'rachnac@gmail.com',
            'password' => bcrypt('12345678'),
            'first_name' => 'chan',
            'last_name' => 'rachna',
            'gender' => 'female',
            'dob' => '2002-01-01',
            'phone_number' => '000000',
            'bio' => 'wish to be an integral part of your life!!',
            'role_id' => 1,
        ]);
        User::create([
            'username' => 'zaponh',
            'email' => 'zaponh@gmail.com',
            'password' => bcrypt('12345678'),
            'first_name' => 'hong',
            'last_name' => 'zapon',
            'gender' => 'female',
            'dob' => '2001-01-01',
            'phone_number' => '000000',
            'bio' => 'wish to be an integral part of your life!!',
            'role_id' => 2,
        ]);
        User::create([
            'username' => 'erekal',
            'email' => 'erekal@gmail.com',
            'password' => bcrypt('12345678'),
            'first_name' => 'lengly',
            'last_name' => 'ereka',
            'gender' => 'female',
            'dob' => '2002-01-01',
            'phone_number' => '000000',
            'bio' => 'wish to be an integral part of your life!!',
            'role_id' => 1,
        ]);
        User::create([
            'username' => 'pocvenh',
            'email' => 'pocvenhl@gmail.com',
            'password' => bcrypt('12345678'),
            'first_name' => 'ly',
            'last_name' => 'pocvenh',
            'gender' => 'male',
            'dob' => '2002-01-01',
            'phone_number' => '000000',
            'bio' => 'wish to be an integral part of your life!!',
            'role_id' => 2,
        ]);
        User::create([
            'username' => 'sidanakp',
            'email' => 'sidanakp@gmail.com',
            'password' => bcrypt('12345678'),
            'first_name' => 'pov',
            'last_name' => 'sidanak',
            'gender' => 'female',
            'dob' => '2002-01-01',
            'phone_number' => '000000',
            'bio' => 'wish to be an integral part of your life!!',
            'role_id' => 2,
        ]);
    }
}
