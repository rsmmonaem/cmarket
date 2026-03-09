<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload and optimize image
     */
    public function upload(UploadedFile $file, string $directory = 'products', int $maxWidth = 1200, int $maxHeight = 1200): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        // Read image
        $image = $this->manager->read($file);

        // Scale down if larger than max dimensions, maintaining aspect ratio
        $image->scaleDown(width: $maxWidth, height: $maxHeight);

        // Encode to format based on extension
        $extension = strtolower($file->getClientOriginalExtension());
        $encoded = match($extension) {
            'png' => $image->toPng(),
            'webp' => $image->toWebp(85),
            default => $image->toJpeg(85),
        };

        // Store image
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Upload and create thumbnail
     */
    public function uploadWithThumbnail(UploadedFile $file, string $directory = 'products'): array
    {
        $originalPath = $this->upload($file, $directory);

        $thumbnailFilename = 'thumb_' . basename($originalPath);
        $thumbnailPath = $directory . '/' . $thumbnailFilename;

        $image = $this->manager->read($file);
        
        // cover() is v3 equivalent of fit()
        $image->cover(400, 400);

        $extension = strtolower($file->getClientOriginalExtension());
        $encoded = match($extension) {
            'png' => $image->toPng(),
            'webp' => $image->toWebp(80),
            default => $image->toJpeg(80),
        };

        Storage::disk('public')->put($thumbnailPath, (string) $encoded);

        return [
            'original' => $originalPath,
            'thumbnail' => $thumbnailPath,
        ];
    }

    /**
     * Delete image from storage
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }
}
