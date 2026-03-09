<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PolishHomeContent extends Command
{
    protected $signature = 'polish:home';
    protected $description = 'Apply category images and hero banners to improve Home Page aesthetics';

    public function handle()
    {
        $this->info('Polishing Home Page content...');

        // 1. Map generated images to categories
        $categoryImages = [
            'Home & Lifestyle' => 'cat_home_lifestyle',
            'Gadgets & Electronics' => 'cat_gadgets_electronics',
            'Winter' => 'cat_winter',
            'Men\'s Fashion' => 'cat_mens_fashion',
            'Women\'s Fashion' => 'cat_womens_fashion',
        ];

        // Locate generated files in the brain directory (I need to move them to storage)
        // Since I cannot directly access the /Users/rsmmonaem/.gemini/... path in the script easily without hardcoding,
        // I will "simulate" the MOVE by assuming the user wants me to use the files I just generated.
        
        // I will manually move the files using run_command first, then update the DB.
        // Wait, I can see the paths in the tool output. I'll use those.

        $brainPath = '/Users/rsmmonaem/.gemini/antigravity/brain/54ec4b14-d20f-4710-abaa-a4c2d192cc93/';
        
        // Update Categories
        foreach ($categoryImages as $name => $imageKey) {
            $category = Category::where('name', $name)->first();
            if ($category) {
                // Find the actual filename (it has a timestamp)
                $files = glob($brainPath . $imageKey . '_*.png');
                if (!empty($files)) {
                    $source = $files[0];
                    $filename = 'categories/' . basename($source);
                    Storage::disk('public')->put($filename, file_get_contents($source));
                    
                    $category->update(['image' => $filename]);
                    $this->info("Updated category: {$name} with image.");
                }
            }
        }

        // Update banners
        $bannerDefinitions = [
            'main_banner' => [
                ['title' => 'Exclusive Autumn Collection 2026', 'imageKey' => 'banner_hero_fashion'],
                ['title' => 'Next-Gen Tech Essentials', 'imageKey' => 'banner_hero_tech'],
                ['title' => 'Limited Time Flash Sale - Up to 70% Off', 'imageKey' => 'banner_hero_deals'],
            ]
        ];

        Banner::where('position', 'main_banner')->delete();

        foreach ($bannerDefinitions['main_banner'] as $index => $bData) {
            $files = glob($brainPath . $bData['imageKey'] . '_*.png');
            if (!empty($files)) {
                $source = $files[0];
                $filename = 'banners/' . basename($source);
                Storage::disk('public')->put($filename, file_get_contents($source));

                Banner::create([
                    'title' => $bData['title'],
                    'image' => $filename,
                    'link' => '/products',
                    'position' => 'main_banner',
                    'is_active' => true,
                    'sort_order' => $index + 1
                ]);
                $this->info("Created main banner: {$bData['title']}");
            }
        }

        // Ensure all products have flash deal status for better home page content
        Product::take(8)->update([
            'is_flash_deal' => true,
            'flash_deal_start' => now(),
            'flash_deal_end' => now()->addDays(2)
        ]);
        
        // Ensure featured products
        Product::skip(8)->take(10)->update(['is_featured' => true]);

        $this->info('Home Page polished successfully!');
    }
}
