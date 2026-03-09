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
            'title' => 'Nexus Mega Sale',
            'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format&fit=crop',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Banner::updateOrCreate(['position' => 'mid_banner'], [
            'title' => 'Next-Gen Electronics',
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1999&auto=format&fit=crop',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Banner::updateOrCreate(['position' => 'popup_banner'], [
            'title' => 'New Season Fashion',
            'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // 2. Seed Categories
        $categories = [
            ['name' => 'Electronics', 'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=2070&auto=format&fit=crop'],
            ['name' => 'Fashion', 'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => Str::slug($cat['name'])], [
                'name' => $cat['name'],
                'image' => $cat['image'],
                'is_active' => true,
                'sort_order' => rand(1, 100),
                'description' => 'Premium ' . $cat['name'] . ' collection'
            ]);
        }

        // 3. Seed Merchants (Keeping one for testing if needed)
        $merchantsData = [
            [
                'email' => 'merchant@cmarket.com',
                'name' => 'Modern Tech Hub',
                'shop_name' => 'Tech Hub Store',
                'logo' => null
            ],
            [
                'email' => 'fashion@cmarket.com',
                'name' => 'Elite Fashion',
                'shop_name' => 'Elite Collections',
                'logo' => null
            ],
        ];

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
                'business_address' => 'Corporate Plaza',
                'business_phone' => $user->phone,
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            // Wallets
            foreach (['main', 'cashback', 'commission', 'shop', 'share'] as $type) {
                Wallet::firstOrCreate(['user_id' => $user->id, 'wallet_type' => $type], ['is_locked' => false]);
            }
        }
    }
}
