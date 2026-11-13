<?php

namespace App\Services;

use Intervention\Image\ImageManager as BaseImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ImageManager extends BaseImageManager
{
    public static function gd(): static
    {
        return new static(new Driver());
    }
}

class ImageOptimizerService
{
    /**
     * Optimize uploaded image, convert to WebP, resize if needed, and store.
     *
     * @param UploadedFile|string $uploadedFile
     * @param string $folder
     * @param int $maxWidth
     * @return string Relative path stored in public disk (e.g. optimized/artists/abc.webp)
     */
    public static function optimizeAndStore($uploadedFile, string $folder, int $maxWidth = 1000): string
    {
        $realPath = $uploadedFile instanceof UploadedFile ? $uploadedFile->getRealPath() : $uploadedFile;
        
        $encoded = ImageManager::gd()
            ->decodePath($realPath)
            ->scaleDown(width: $maxWidth)
            ->encodeUsingMediaType('image/webp', quality: 82);

        $filename = Str::random(40);
        $path = "optimized/{$folder}/{$filename}.webp";

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Helper to return the default placeholder WebP URL.
     *
     * @return string
     */
    public static function placeholderUrl(): string
    {
        return asset('images/rude-hz-placeholder.webp');
    }
}
