<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    /**
     * Upload and optimize image
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $maxWidth
     * @param int $maxHeight
     * @return string Path to stored image
     */
    public function upload(UploadedFile $file, string $directory = 'products', int $maxWidth = 800, int $maxHeight = 800): string
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        // Load and optimize image
        $image = Image::make($file);

        // Resize if larger than max dimensions
        if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
            $image->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Optimize quality
        $image->encode($file->getClientOriginalExtension(), 85);

        // Store image
        Storage::disk('public')->put($path, (string) $image);

        return $path;
    }

    /**
     * Upload and create thumbnail
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return array ['original' => path, 'thumbnail' => path]
     */
    public function uploadWithThumbnail(UploadedFile $file, string $directory = 'products'): array
    {
        // Upload original (optimized)
        $originalPath = $this->upload($file, $directory);

        // Create thumbnail
        $thumbnailFilename = 'thumb_' . basename($originalPath);
        $thumbnailPath = $directory . '/' . $thumbnailFilename;

        $thumbnail = Image::make($file);
        $thumbnail->fit(200, 200);
        $thumbnail->encode($file->getClientOriginalExtension(), 80);

        Storage::disk('public')->put($thumbnailPath, (string) $thumbnail);

        return [
            'original' => $originalPath,
            'thumbnail' => $thumbnailPath,
        ];
    }

    /**
     * Delete image from storage
     *
     * @param string|null $path
     * @return bool
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }
}
