<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Nitesh',
            'email' => 'niteshhamal@gmail.com',
            // 'email_veriied_at' => Carbon::now(),
            'password' => 'Password',
        ]);
    }
}
