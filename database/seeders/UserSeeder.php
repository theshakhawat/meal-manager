<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'shakhawat9083@gmail.com',
            'password' => bcrypt('shakhawat9083@gmail.com'),
            'phone' => '01700000000',
            'photo' => null,
        ]);
    }
}
