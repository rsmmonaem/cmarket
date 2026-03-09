<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportProducts extends Command
{
    protected $signature = 'import:products';
    protected $description = 'Import products and categories from Mohasagor API';

    public function handle()
    {
        $this->info('Starting import...');

        $response = Http::get('https://mohasagor.com.bd/api/reseller/product');

        if ($response->failed()) {
            $this->error('Failed to fetch data from API');
            return;
        }

        $data = $response->json();
        $products = $data['products'] ?? [];

        if (empty($products)) {
            $this->error('No products found in the API response');
            return;
        }

        // Get or create a default merchant
        $merchant = Merchant::first();
        if (!$merchant) {
            $this->warn('No merchant found. Creating a default merchant...');
            $user = \App\Models\User::where('email', 'merchant@example.com')->first();
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => 'Default Merchant',
                    'email' => 'merchant@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'phone' => '0123456789',
                    'status' => 'merchant'
                ]);
            }
            $merchant = Merchant::create([
                'user_id' => $user->id,
                'business_name' => 'Default Shop',
                'status' => 'approved',
                'approved_at' => now()
            ]);
        }

        $importedCategoriesCount = 0;
        $categoryMap = []; // Name -> ID
        $productCount = 0;
        $maxProducts = 40;
        $maxCategories = 10;

        foreach ($products as $item) {
            if ($productCount >= $maxProducts) {
                break;
            }

            // Handle Category
            $categoryName = $item['category'];
            
            // If category not yet mapped
            if (!isset($categoryMap[$categoryName])) {
                // Check if we can add a new category
                if ($importedCategoriesCount >= $maxCategories) {
                    // We already have 10 categories. Skip any product from a new category.
                    continue;
                }

                $category = Category::where('name', $categoryName)->first();
                if (!$category) {
                    $category = Category::create([
                        'name' => $categoryName,
                        'slug' => Str::slug($categoryName),
                        'is_active' => true
                    ]);
                    $this->info("Category: {$categoryName} created.");
                } else {
                    $this->info("Category: {$categoryName} found.");
                }
                
                $categoryMap[$categoryName] = $category->id;
                $importedCategoriesCount++;
            }

            $categoryId = $categoryMap[$categoryName];

            // Handle Product
            $productSlug = Str::slug($item['name']) . '-' . $item['product_code'];
            
            // Download thumbnail
            $thumbnailPath = null;
            if (!empty($item['thumbnail_img'])) {
                $thumbnailPath = $this->downloadImage($item['thumbnail_img'], 'products/thumbnails');
            }

            // Download gallery images
            $galleryImages = [];
            if (!empty($item['product_images'])) {
                foreach ($item['product_images'] as $img) {
                    $imgPath = $this->downloadImage($img['product_image'], 'products/gallery');
                    if ($imgPath) {
                        $galleryImages[] = $imgPath;
                    }
                }
            }

            $productData = [
                'merchant_id' => $merchant->id,
                'category_id' => $categoryId,
                'name' => $item['name'],
                'slug' => $productSlug,
                'description' => $item['details'],
                'price' => $item['price'],
                'discount_price' => $item['sale_price'],
                'stock' => rand(10, 100),
                'thumbnail' => $thumbnailPath,
                'images' => $galleryImages,
                'sku' => $item['product_code'],
                'status' => 'active',
                'type' => 'product' // Fixed from 'physical'
            ];

            Product::updateOrCreate(
                ['sku' => $item['product_code']],
                $productData
            );

            $productCount++;
            $this->info("Product: {$item['name']} imported ({$productCount}).");
        }

        $this->info('Import completed successfully!');
    }

    private function downloadImage($url, $folder)
    {
        try {
            // Encode spaces in URL if any
            $url = str_replace(' ', '%20', $url);
            $response = Http::get($url);
            if ($response->failed()) {
                return null;
            }
            $contents = $response->body();
            $name = basename($url);
            // Append short random string to avoid name collisions if multiple products use same filename in different URLs
            $name = Str::random(5) . '_' . $name;
            $path = $folder . '/' . $name;
            Storage::disk('public')->put($path, $contents);
            return $path;
        } catch (\Exception $e) {
            $this->warn("Failed to download image: {$url}");
            return null;
        }
    }
}
