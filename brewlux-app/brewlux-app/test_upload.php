<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;

// Test 1: Check if public disk is writable
$testFile = 'test_'.time().'.txt';
try {
    $result = Storage::disk('public')->put($testFile, 'test content');
    echo "Test file written: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    if ($result) {
        $exists = Storage::disk('public')->exists($testFile);
        echo "Test file exists: " . ($exists ? 'YES' : 'NO') . "\n";
        
        Storage::disk('public')->delete($testFile);
        echo "Test file deleted\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test 2: Check products folder
try {
    $folders = Storage::disk('public')->directories();
    echo "Folders in public disk: " . json_encode($folders) . "\n";
} catch (Exception $e) {
    echo "Error listing folders: " . $e->getMessage() . "\n";
}

// Test 3: List files in products folder
try {
    $files = Storage::disk('public')->files('products');
    echo "Files in products folder: " . json_encode($files) . "\n";
} catch (Exception $e) {
    echo "Error listing products: " . $e->getMessage() . "\n";
}
