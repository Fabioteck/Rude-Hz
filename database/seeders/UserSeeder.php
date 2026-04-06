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
        User::create([
            'name' => 'Fabio Admin',
            'email' => 'frigeriwki@gmail.com',
            'password' => Hash::make('techno'), // Metti la password che preferisci
        ]);

        // Profilo Artista di Test (se vuoi un secondo account)
        User::create([
            'name' => 'Fabio Artist',
            'email' => 'artist@rude-hz.it',
            'password' => Hash::make('techno'),
        ]);
    }
}
