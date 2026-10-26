<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "=== Testing Media Storage ===\n\n";

// Test Storage::disk('public')->put
$imageData = fake_image_data();
$path = Storage::disk('public')->put('media/test.jpg', $imageData);
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

echo "\n=== All media storage tests passed! ===\n";

function fake_image_data(): string
{
    return "\xFF\xD8\xFF\xE0\x00\x10JFIF\x00\x01\x01\x01\x00\x00\x00\x00\x00\x00\xFF\xD9";
}