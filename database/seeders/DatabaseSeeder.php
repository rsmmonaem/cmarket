<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Designation;
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

        // 2. MLM Test Chain
        $this->call(MLMTestSeeder::class);

        // 2. Global System Configuration
        $this->call(SystemSettingsSeeder::class);

        // 3. Platform Hierarchies
        $this->call(DesignationSeeder::class);

        // 4. Investment Marketplace Core
        $this->call(ChainShopSeeder::class);

        // 5. Ecommerce Demo Data (Products, Categories, Banners)
        $this->call(EcommerceDemoSeeder::class);

        // 6. Super Admin Initialization
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

        // 7. Test Customer Initialization
        $customer = User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => '2nd user',
                'phone' => '01968402925',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );

        // Auto-assign top priority designation (Priority 1)
        // Note: Using sort_order as it represents priority in our system (1 = Top)
        $designation = Designation::where('sort_order', 1)->first();
        if ($designation) {
            $customer->update(['designation_id' => $designation->id]);
        }

        if ($customer->wasRecentlyCreated || !$customer->hasRole('customer')) {
            $customer->assignRole('customer');
        }

        // 8. Mandatory Wallet Infrastructure
        $walletTypes = ['main', 'cashback', 'commission', 'shop', 'share'];
        
        $usersToSetup = [$superAdmin, $customer];

        foreach ($usersToSetup as $user) {
            foreach ($walletTypes as $type) {
                Wallet::firstOrCreate([
                    'user_id' => $user->id,
                    'wallet_type' => $type
                ], [
                    'is_locked' => false,
                ]);
            }
        }

        $this->command->info('Ecosystem Protocol Deployment Successful!');
    }
}
