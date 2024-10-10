<?php

namespace App\Presenter\Traits;

use Illuminate\Support\Facades\File;

trait UploadImageTrait
{
    /**
     * Upload image.
     */
    public static function uploadImage(mixed $file, string $path = 'upload'): string
    {
        $extension = $file->extension();
        $fileName = 'media_' . uniqid();
        $file->storeAs($path, $fileName . '.' . $extension, 'public');
        $uploadedImagePath = 'storage/' . $path . '/' . $fileName . '.' . $extension;
        if (in_array($extension, ['svg', 'webp'])) {
            return $uploadedImagePath;
        }
        $webpImagePath = 'storage/' . $path . '/' . pathinfo($fileName . '.' . $extension, PATHINFO_FILENAME) . '.webp';
        self::encodeToWebp($uploadedImagePath, $webpImagePath);

        return $webpImagePath;
    }

    /**
     * @param string $path : default is 'upload'
     */
    public static function updateImage(mixed $file, string $path = 'upload', string $oldPath = null): string
    {
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }

        return self::uploadImage($file, $path);
    }

    /** Handle Delete File.*/
    public static function deleteImage(string $path): void
    {
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    /**
     * Encode image to webp.
     */
    public static function encodeToWebp(mixed $sourceImage, mixed $outputImage, int $quality = 80): void
    {
        $extension = pathinfo($sourceImage, PATHINFO_EXTENSION);
        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($sourceImage);
                break;
            case 'png':
                $image = imagecreatefrompng($sourceImage);
                break;
            case 'gif':
                $image = imagecreatefromgif($sourceImage);
                break;
            case 'bmp':
                $image = imagecreatefrombmp($sourceImage);
                break;
            default:
                return;
        }
        imagewebp($image, $outputImage, $quality);
        imagedestroy($image);
        if (file_exists($sourceImage)) {
            unlink($sourceImage);
        }
    }
}
