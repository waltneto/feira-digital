<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$item = \App\Models\ItemCarrinho::first();
if ($item) {
    echo "Item ID: " . $item->id . "\n";
    echo "Route update URL: " . route('carrinho.update', $item) . "\n";
    echo "Route destroy URL: " . route('carrinho.destroy', $item) . "\n";
} else {
    echo "No items found in DB.";
}
