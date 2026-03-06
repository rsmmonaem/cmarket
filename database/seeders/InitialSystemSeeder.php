<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use App\Models\SystemSetting;

class InitialSystemSeeder extends Seeder
{
    public function run(): void
    {
        // Initial Banners
        Banner::updateOrCreate(['title' => 'Main Launch Banner'], [
            'position' => 'main_banner',
            'image' => 'banners/main-sample.jpg',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Banner::updateOrCreate(['title' => 'Flash Deal Promo'], [
            'position' => 'mid_banner',
            'image' => 'banners/mid-sample.jpg',
            'link' => '/products',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Banner::updateOrCreate(['title' => 'Welcome Popup'], [
            'position' => 'popup_banner',
            'image' => 'banners/popup-sample.jpg',
            'link' => '/register',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Initial Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'EcomMatrix', 'type' => 'string', 'group' => 'general', 'description' => 'Global Platform Name'],
            ['key' => 'referral_commission', 'value' => '10', 'type' => 'decimal', 'group' => 'commission', 'description' => 'Standard Referral Reward Percentage'],
            ['key' => 'enable_flash_deals', 'value' => '1', 'type' => 'boolean', 'group' => 'ui_toggles', 'description' => 'Toggle Flash Deals Matrix on Homepage'],
            ['key' => 'enable_popup_banner', 'value' => '1', 'type' => 'boolean', 'group' => 'ui_toggles', 'description' => 'Toggle Global Entry Popup'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'system', 'description' => 'Kill External Access Nodes'],
            ['key' => 'enable_pos_system', 'value' => '1', 'type' => 'boolean', 'group' => 'operational', 'description' => 'Activate Point of Sale Module'],
            ['key' => 'enable_affiliate_system', 'value' => '1', 'type' => 'boolean', 'group' => 'operational', 'description' => 'Activate Affiliate Program'],
            ['key' => 'enable_merchant_signup', 'value' => '1', 'type' => 'boolean', 'group' => 'merchants', 'description' => 'Allow External Merchant Intake'],
            ['key' => 'admin_commission_rate', 'value' => '5', 'type' => 'decimal', 'group' => 'commission', 'description' => 'Standard Platform Fee'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
