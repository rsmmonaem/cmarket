<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EcommerceDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Banners
        Banner::updateOrCreate(['position' => 'main_banner'], [
            'title' => 'Nexus Summer Collection',
            'image' => 'banners/main.jpg',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Banner::updateOrCreate(['position' => 'mid_banner'], [
            'title' => 'Quantum Wearables',
            'image' => 'banners/mid.jpg',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Banner::updateOrCreate(['position' => 'popup_banner'], [
            'title' => 'First Order Discount!',
            'image' => 'banners/popup.jpg',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // 2. Seed Categories
        $categories = [
            ['name' => 'Electronics', 'image' => 'categories/electronics.jpg'],
            ['name' => 'Fashion', 'image' => 'categories/fashion.jpg'],
            ['name' => 'Organic Foods', 'image' => 'categories/groceries.jpg'],
            ['name' => 'Home Decor', 'image' => null],
            ['name' => 'Health & Beauty', 'image' => null],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => Str::slug($cat['name'])], [
                'name' => $cat['name'],
                'image' => $cat['image'],
                'is_active' => true,
                'sort_order' => rand(1, 100),
                'description' => 'Demo category ' . $cat['name']
            ]);
        }

        // 3. Seed Merchants
        $merchantsData = [
            [
                'email' => 'merchant@cmarket.com',
                'name' => 'Matrix Tech Merchant',
                'shop_name' => 'Matrix Tech Store',
                'logo' => 'merchants/matrix-tech.png'
            ],
            [
                'email' => 'fashion@cmarket.com',
                'name' => 'Vogue Boutique Merchant',
                'shop_name' => 'Vogue Boutique',
                'logo' => 'merchants/vogue.png'
            ],
            [
                'email' => 'organic@cmarket.com',
                'name' => 'Pure Nature Merchant',
                'shop_name' => 'Pure Nature Organics',
                'logo' => 'merchants/pure-nature.png'
            ],
        ];

        $merchants = [];
        foreach ($merchantsData as $md) {
            $user = User::updateOrCreate(['email' => $md['email']], [
                'name' => $md['name'],
                'phone' => '017' . rand(11111111, 99999999),
                'password' => Hash::make('password'),
                'status' => 'wallet_verified',
            ]);
            
            if (!$user->hasRole('merchant')) {
                $user->assignRole('merchant');
            }

            $merch = Merchant::updateOrCreate(['user_id' => $user->id], [
                'business_name' => $md['shop_name'],
                'logo' => $md['logo'] ?? null,
                'trade_license' => 'TL-' . rand(100, 999),
                'business_address' => 'City Hub, Floor ' . rand(1, 10),
                'business_phone' => $user->phone,
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            // Wallets
            foreach (['main', 'cashback', 'commission', 'shop', 'share'] as $type) {
                Wallet::firstOrCreate(['user_id' => $user->id, 'wallet_type' => $type], ['is_locked' => false]);
            }
            
            $merchants[] = $merch;
        }

        // 4. Seed Products
        $demoProducts = [
            [
                'name' => 'iPhone 15 Pro',
                'category' => 'Electronics',
                'price' => 140000,
                'discount' => 135000,
                'image' => 'products/iphone.jpg',
                'featured' => true,
                'flash' => true,
                'merchant_index' => 0
            ],
            [
                'name' => 'Neural Knit T-Shirt',
                'category' => 'Fashion',
                'price' => 1200,
                'discount' => 950,
                'image' => 'products/tshirt.jpg',
                'featured' => true,
                'flash' => false,
                'merchant_index' => 1
            ],
            [
                'name' => 'Quantum Step Shoes',
                'category' => 'Fashion',
                'price' => 8500,
                'discount' => null,
                'image' => 'products/shoes.jpg',
              'featured' => false,
                'flash' => true,
                'merchant_index' => 1
            ],
            [
                'name' => 'Lumina X Laptop',
                'category' => 'Electronics',
                'price' => 85000,
                'discount' => 78000,
                'image' => 'products/laptop.jpg',
                'featured' => true,
                'flash' => false,
                'merchant_index' => 0
            ],
            [
                'name' => 'Chronos Pulse Watch',
                'category' => 'Electronics',
                'price' => 15000,
                'discount' => 12500,
                'image' => 'products/watch.jpg',
                'featured' => true,
                'flash' => true,
                'merchant_index' => 0
            ],
            [
                'name' => 'Organic Honey',
                'category' => 'Organic Foods',
                'price' => 2500,
                'discount' => 2200,
                'image' => 'products/honey.jpg',
                'featured' => true,
                'flash' => false,
                'merchant_index' => 2
            ],
            [
                'name' => 'Pure Argan Oil',
                'category' => 'Health & Beauty',
                'price' => 4500,
                'discount' => 3800,
                'image' => 'products/oil.jpg',
                'featured' => true,
                'flash' => false,
                'merchant_index' => 2
            ],
        ];

        foreach ($demoProducts as $dp) {
            $cat = Category::where('name', $dp['category'])->first();
            if (!$cat) continue;

            Product::updateOrCreate(['slug' => Str::slug($dp['name'])], [
                'merchant_id' => $merchants[$dp['merchant_index']]->id,
                'category_id' => $cat->id,
                'type' => 'product',
                'name' => $dp['name'],
                'description' => 'Premium quality ' . $dp['name'] . ' for your needs.',
                'price' => $dp['price'],
                'discount_price' => $dp['discount'],
                'stock' => rand(10, 100),
                'images' => [$dp['image']],
                'sku' => strtoupper(Str::random(10)),
                'status' => 'active',
                'is_featured' => $dp['featured'],
                'is_flash_deal' => $dp['flash'],
                'flash_deal_start' => $dp['flash'] ? now() : null,
                'flash_deal_end' => $dp['flash'] ? now()->addDays(3) : null,
            ]);
        }
    }
}
