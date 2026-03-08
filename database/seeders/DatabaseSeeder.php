<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Role & Permission Infrastructure
        $this->call(RolePermissionSeeder::class);

        // 2. Global System Configuration
        $this->call(SystemSettingsSeeder::class);

        // 3. Platform Hierarchies
        $this->call(DesignationSeeder::class);

        // 4. Investment Marketplace Core
        $this->call(ChainShopSeeder::class);

        // 5. Ecommerce Demo Data (Products, Categories, Banners)
        $this->call(EcommerceDemoSeeder::class);

        // 6. Super Admin Initialization (Safe Deployment)
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@cmarket.com'],
            [
                'name' => 'Super Admin',
                'phone' => '01700000000',
                'password' => Hash::make('password'),
                'status' => 'wallet_verified',
            ]
        );

        if ($superAdmin->wasRecentlyCreated || !$superAdmin->hasRole('super-admin')) {
            $superAdmin->assignRole('super-admin');
        }

        // 7. Mandatory Wallet Infrastructure for Admin
        $walletTypes = ['main', 'cashback', 'commission', 'shop', 'share'];
        foreach ($walletTypes as $type) {
            Wallet::firstOrCreate([
                'user_id' => $superAdmin->id,
                'wallet_type' => $type
            ], [
                'is_locked' => false,
            ]);
        }

        $this->command->info('Ecosystem Protocol Deployment Successful!');
    }
}
