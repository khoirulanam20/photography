<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'superadmin',
            'name' => 'Superadmin',
            'role' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'no_wa' => '085156985698',
            'password' => Hash::make('password'), // Pastikan mengganti 'password' dengan kata sandi yang aman
       
        ]);
    }
}