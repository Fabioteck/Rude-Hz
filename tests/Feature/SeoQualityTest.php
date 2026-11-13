<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{Artist, Track, News, Contest, Playlist};

class SeoQualityTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_seo_and_front_end_quality()
    {
        $user = \App\Models\User::factory()->create();
        $artist = Artist::create(['user_id' => $user->id, 'name' => 'Test Artist', 'slug' => 'test-artist']);
        Track::create(['user_id' => $user->id, 'artist_id' => $artist->id, 'title' => 'Test Track', 'slug' => 'test-track', 'file_path' => 'test.mp3', 'is_approved' => true]);
        News::create(['user_id' => $user->id, 'title' => 'Test News', 'slug' => 'test-news', 'content' => 'Content', 'is_published' => true]);
        Contest::create(['title' => 'Test Contest', 'slug' => 'test-contest', 'description' => 'Desc', 'is_active' => true]);
        Playlist::create(['user_id' => $user->id, 'title' => 'Test Playlist', 'slug' => 'test-playlist']);

        $pages = [
            '/' => 'Home',
            '/project' => 'Project',
            '/artists' => 'Artists',
            '/tracks' => 'Tracks',
            '/playlists' => 'Playlists',
            '/playlist' => 'Playlist (Alias)',
            '/news' => 'News',
            '/contests' => 'Contests',
            '/support' => 'Support',
        ];

        echo "\n" . str_pad("PAGINA", 15) . " | " . str_pad("TITLE", 30) . " | " . str_pad("DESCRIPTION", 20) . " | " . str_pad("OG", 5) . " | " . str_pad("CANONICAL", 10) . " | " . str_pad("PASS/FAIL", 10) . "\n";
        echo str_repeat("-", 105) . "\n";

        foreach ($pages as $uri => $label) {
            $response = $this->get($uri);
            $status = $response->status();
            
            // For redirect (/playlist)
            if ($uri === '/playlist') {
                $hasStatus = in_array($status, [200, 301, 302]);
                $passFail = $hasStatus ? 'PASS' : 'FAIL';
                echo str_pad($uri, 15) . " | " . str_pad("Redirect (301/302)", 30) . " | " . str_pad("-", 20) . " | " . str_pad("-", 5) . " | " . str_pad("-", 10) . " | " . str_pad($passFail, 10) . "\n";
                $this->assertTrue($hasStatus);
                continue;
            }

            $content = $response->getContent();

            $hasTitle = str_contains($content, '<title>');
            $hasDesc = str_contains($content, 'name="description"');
            $hasOg = str_contains($content, 'property="og:title"');
            $hasCanonical = str_contains($content, 'rel="canonical"');

            // Count H1 tags
            preg_match_all('/<h1\b[^>]*>/i', $content, $matches);
            $h1Count = count($matches[0]);
            $singleH1 = ($h1Count === 1);

            $pass = ($status === 200 && $hasTitle && $hasDesc && $hasOg && $hasCanonical && $singleH1);
            $passFail = $pass ? 'PASS' : 'FAIL (Status:' . $status . ', H1s:' . $h1Count . ')';

            $titleSnippet = 'Rude-Hz';
            if (preg_match('/<title>(.*?)<\/title>/i', $content, $tMatch)) {
                $titleSnippet = substr($tMatch[1], 0, 28);
            }

            echo str_pad($uri, 15) . " | " . str_pad($titleSnippet, 30) . " | " . str_pad($hasDesc ? 'YES' : 'NO', 20) . " | " . str_pad($hasOg ? 'YES' : 'NO', 5) . " | " . str_pad($hasCanonical ? 'YES' : 'NO', 10) . " | " . str_pad($passFail, 10) . "\n";

            $this->assertEquals(200, $status);
            $this->assertTrue($hasTitle, "Missing title on $uri");
            $this->assertTrue($hasDesc, "Missing description on $uri");
            $this->assertTrue($hasOg, "Missing Open Graph on $uri");
            $this->assertTrue($hasCanonical, "Missing canonical on $uri");
            $this->assertTrue($singleH1, "H1 count is not 1 on $uri (found $h1Count)");
        }
        echo str_repeat("-", 105) . "\n";
    }
}
