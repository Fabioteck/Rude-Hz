<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Playlist;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RudeHzStarterSeeder extends Seeder
{
    public function run(): void
    {
        $adminPassword = env('RUDE_ADMIN_PASSWORD');
        if (empty($adminPassword)) {
            throw new \Exception('ERRORE: La variabile d ambiente RUDE_ADMIN_PASSWORD non è impostata. Processo interrotto.');
        }

        // Clean up excess records to match exact starter counts (Users=1, Artists=1, Tracks=3, Playlists=1, News=1)
        DB::table('playlist_track')->delete();
        Track::whereNotIn('slug', ['rude-starter-01', 'rude-starter-02', 'rude-starter-03'])->delete();
        Playlist::where('slug', '!=', 'rude-hz-starter')->delete();
        News::where('slug', '!=', 'rude-hz-tornato-online')->delete();
        Artist::where('slug', '!=', 'fabioteck')->delete();
        User::where('email', '!=', 'admin@rude-hz.it')->delete();

        // 1. Admin User
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@rude-hz.it'],
            [
                'name' => 'Rude-Hz Admin',
                'password' => Hash::make($adminPassword),
                'plan' => 'free',
                'email_verified_at' => now(),
            ]
        );

        // 2. Artist
        $artist = Artist::updateOrCreate(
            ['slug' => 'fabioteck'],
            [
                'user_id' => $adminUser->id,
                'name' => 'FabioTeck',
                'bio' => 'Producer e fondatore della community Rude-Hz.',
                'style' => 'Tekno / Underground',
                'is_active' => true,
            ]
        );

        // 3. Tracks (3 tracks linked to real existing audio files in storage)
        $trackData = [
            [
                'title' => 'Rude Starter 01',
                'slug' => 'rude-starter-01',
                'genre' => 'Tekno',
                'version' => 'Original Mix',
                'file_path' => 'tracks/audio/hZoHTImlHXqMWO1oLWmcpoz1rDUCdfTieocjGJ77.mp3',
                'is_approved' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Rude Starter 02',
                'slug' => 'rude-starter-02',
                'genre' => 'Hard Tekno',
                'version' => 'Original Mix',
                'file_path' => 'tracks/audio/OAhzd1IqokgY7xHvXpW8yNrFlqCyOtie2IDj5leR.mp3',
                'is_approved' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Rude Starter 03',
                'slug' => 'rude-starter-03',
                'genre' => 'Industrial Tekno',
                'version' => 'Original Mix',
                'file_path' => 'tracks/audio/5oXfMfecXeenPppMfgDwKcK7TFYrprESamyMEjyl.mp3',
                'is_approved' => true,
                'is_published' => true,
            ],
        ];

        $createdTracks = [];
        foreach ($trackData as $data) {
            $track = Track::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'artist_id' => $artist->id,
                    'user_id' => $adminUser->id,
                    'approved_at' => now(),
                ])
            );
            $createdTracks[] = $track;
        }

        // 4. Playlist
        $playlist = Playlist::updateOrCreate(
            ['slug' => 'rude-hz-starter'],
            [
                'title' => 'Rude-Hz Starter',
                'description' => 'Playlist iniziale della community.',
            ]
        );

        $trackIds = collect($createdTracks)->pluck('id')->toArray();
        $playlist->tracks()->syncWithoutDetaching($trackIds);

        // 5. News Category & News
        $category = NewsCategory::firstOrCreate(
            ['slug' => 'community'],
            ['name' => 'Community']
        );

        News::updateOrCreate(
            ['slug' => 'rude-hz-tornato-online'],
            [
                'title' => 'Rude-Hz è tornato online',
                'subtitle' => 'Nuova base tecnica e ripartenza',
                'content' => 'La community Rude-Hz riparte con una nuova base tecnica. Artisti, tracce e playlist verranno ricostruiti progressivamente.',
                'category_id' => $category->id,
                'user_id' => $adminUser->id,
                'is_published' => true,
            ]
        );
    }
}
