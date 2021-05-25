<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'Doctor',
            'user_name' => 'doctor',
            'user_type' => 'DOCTOR',
            'email' => 'doctor@gmail.com',
            'phone' => '00162435223',
            'password' => bcrypt('123456'),
            'gender' => 'Male'
        ]);

        User::create([
            'full_name' => 'Patient',
            'user_name' => 'patient',
            'user_type' => 'PATIENT',
            'email' => 'pathient@gmail.com',
            'phone' => '00162435224',
            'password' => bcrypt('123456'),
            'gender' => 'Male'
        ]);
    }
}
