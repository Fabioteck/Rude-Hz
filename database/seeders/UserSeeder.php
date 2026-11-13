<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tuo Profilo Admin
        User::firstOrCreate(
            ['email' => 'frigeriwki@gmail.com'],
            [
                'name' => 'Fabio Admin',
                'password' => Hash::make('techno'),
                'is_admin' => true,
            ]
        );

        // Profilo Artista di Test (se vuoi un secondo account)
        User::firstOrCreate(
            ['email' => 'artist@rude-hz.it'],
            [
                'name' => 'Fabio Artist',
                'password' => Hash::make('techno'),
            ]
        );
    }
}
