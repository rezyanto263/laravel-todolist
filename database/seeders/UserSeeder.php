<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'Muhammad Reza Haryanto',
            'email'=> 'rezyanto263@gmail.com',
            'password'=> Hash::make('rahasia'),
        ]);
    }
}
