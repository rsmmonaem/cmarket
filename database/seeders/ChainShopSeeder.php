<?php

namespace Database\Seeders;

use App\Models\ChainShop;
use Illuminate\Database\Seeder;

class ChainShopSeeder extends Seeder
{
    public function run(): void
    {
        $shops = [
            [
                'name' => 'CMarket Mega Mall - Dhaka',
                'description' => 'A prime investment opportunity in the heart of Dhaka. This mega mall features 500+ premium shops and a modern food court.',
                'location' => 'Gulshan, Dhaka',
                'total_shares' => 10000,
                'share_price' => 5000.00,
                'available_shares' => 8500,
                'status' => 'active'
            ],
            [
                'name' => 'Chain Shop Express - Chittagong',
                'description' => 'Fast-growing retail chain specializing in daily essentials and electronics. High ROI projection.',
                'location' => 'Agrabad, Chittagong',
                'total_shares' => 5000,
                'share_price' => 2500.00,
                'available_shares' => 3200,
                'status' => 'active'
            ],
            [
                'name' => 'Agro-Invest Sylhet',
                'description' => 'Investment in hi-tech agriculture and organic farming. Sustainable and high-demand products.',
                'location' => 'Sylhet Town',
                'total_shares' => 8000,
                'share_price' => 1500.00,
                'available_shares' => 7000,
                'status' => 'active'
            ]
        ];

        foreach ($shops as $shop) {
            ChainShop::create($shop);
        }
    }
}
