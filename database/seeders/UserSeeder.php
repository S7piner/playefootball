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
        $user = [
            ['name' => 'Wilson ZANNOU', 'email' => 'wilsonzannou7@gmail.com', 'password' => Hash::make('shadowgod229')],
        ];

        foreach($user as $user){
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('shadowgod229'),
            ]);
        }
    }
}
