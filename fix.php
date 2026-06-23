<?php require __DIR__.'/vendor/autoload.php'; require __DIR__.'/bootstrap/app.php'; App\Models\Product::where('is_available', 0)->update(['is_available' => 1]); echo 'Done'; ?>
