<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Designation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call role and permission seeder
        $this->call(RolePermissionSeeder::class);

        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'phone' => '01700000000',
            'email' => 'admin@cmarket.com',
            'password' => Hash::make('password'),
            'status' => 'wallet_verified',
        ]);
        $superAdmin->assignRole('super-admin');

        // Create wallets for super admin
        $walletTypes = ['main', 'cashback', 'commission', 'shop', 'share'];
        foreach ($walletTypes as $type) {
            Wallet::create([
                'user_id' => $superAdmin->id,
                'wallet_type' => $type,
                'is_locked' => false,
            ]);
        }

        // Create default designations
        $designations = [
            [
                'name' => 'BP (Business Partner)',
                'slug' => 'bp',
                'description' => 'Entry level designation',
                'criteria' => [
                    'sales_count' => 10,
                    'referral_count' => 5,
                    'team_levels' => 1,
                ],
                'commission_rate' => 1.0,
                'sort_order' => 1,
            ],
            [
                'name' => 'ME (Marketing Executive)',
                'slug' => 'me',
                'description' => 'Mid-level designation',
                'criteria' => [
                    'sales_count' => 50,
                    'referral_count' => 20,
                    'team_levels' => 2,
                ],
                'commission_rate' => 2.0,
                'sort_order' => 2,
            ],
            [
                'name' => 'BC (Business Coordinator)',
                'slug' => 'bc',
                'description' => 'Senior designation',
                'criteria' => [
                    'sales_count' => 100,
                    'referral_count' => 50,
                    'team_levels' => 3,
                ],
                'commission_rate' => 3.0,
                'sort_order' => 3,
            ],
            [
                'name' => 'Upazila Manager',
                'slug' => 'upazila',
                'description' => 'Upazila level manager',
                'criteria' => [
                    'sales_count' => 200,
                    'referral_count' => 100,
                    'team_levels' => 4,
                ],
                'commission_rate' => 4.0,
                'sort_order' => 4,
            ],
            [
                'name' => 'District Manager',
                'slug' => 'district',
                'description' => 'District level manager',
                'criteria' => [
                    'sales_count' => 500,
                    'referral_count' => 250,
                    'team_levels' => 5,
                ],
                'commission_rate' => 5.0,
                'sort_order' => 5,
            ],
            [
                'name' => 'Division Manager',
                'slug' => 'division',
                'description' => 'Division level manager',
                'criteria' => [
                    'sales_count' => 1000,
                    'referral_count' => 500,
                    'team_levels' => 6,
                ],
                'commission_rate' => 6.0,
                'sort_order' => 6,
            ],
            [
                'name' => 'Director',
                'slug' => 'director',
                'description' => 'Top level designation',
                'criteria' => [
                    'sales_count' => 2000,
                    'referral_count' => 1000,
                    'team_levels' => 7,
                ],
                'commission_rate' => 7.0,
                'sort_order' => 7,
            ],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }

        $this->command->info('Database seeded successfully!');
    }
}
