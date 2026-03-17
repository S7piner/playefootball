<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Wilson ZANNOU',
            'email' => 'wilsonzannou7@gmail.com',
            'password' => Hash::make('shadowgod229'),
        ]);

        Admin::create([
            'user_id' => $user->id,
        ]);
    }
}
