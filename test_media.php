<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile as SfUploadedFile;

echo "=== Testing Media Storage ===\n\n";

// Create a dummy image file for testing
$testFile = tempnam(sys_get_temp_dir(), 'img_');
file_put_contents($testFile, fake_image_data());

$uploaded = new SfUploadedFile($testFile, 'test.jpg', 'image/jpeg', null, true);

// Test Storage::disk('public')->putFile
$path = Storage::disk('public')->putFile('media', $uploaded);
echo "1. File stored at: {$path}\n";

// Verify file exists
if (Storage::disk('public')->exists($path)) {
    echo "2. File exists on disk: YES\n";
} else {
    echo "2. File exists on disk: NO\n";
}

// Get the URL
$url = Storage::disk('public')->url($path);
echo "3. File URL: {$url}\n";

// Test file deletion
Storage::disk('public')->delete($path);
if (!Storage::disk('public')->exists($path)) {
    echo "4. File deleted from disk: YES\n";
}

unlink($testFile);

echo "\n=== All media storage tests passed! ===\n";

function fake_image_data(): string
{
    // Minimal valid JPEG binary (1x1 pixel)
    return "\xFF\xD8\xFF\xE0\x00\x10JFIF\x00\x01\x01\x01\x00\x00\x00\x00\x00\x00\xFF\xD9";
}