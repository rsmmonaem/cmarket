<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Commission Protocol
            [
                'key' => 'referral_bonus',
                'value' => '50.00',
                'type' => 'decimal',
                'group' => 'commission',
                'description' => 'Fixed bonus for direct node referral'
            ],
            [
                'key' => 'matching_bonus_percentage',
                'value' => '10.00',
                'type' => 'decimal',
                'group' => 'commission',
                'description' => 'Percentage earned from high-level team matching'
            ],
            [
                'key' => 'indirect_commission_level_1',
                'value' => '5.00',
                'type' => 'decimal',
                'group' => 'commission',
                'description' => 'Tier 1 indirect yield'
            ],
            [
                'key' => 'indirect_commission_level_2',
                'value' => '3.00',
                'type' => 'decimal',
                'group' => 'commission',
                'description' => 'Tier 2 indirect yield'
            ],

            // Payment Protocol
            [
                'key' => 'min_withdrawal_amount',
                'value' => '500.00',
                'type' => 'decimal',
                'group' => 'payment',
                'description' => 'Minimum threshold for financial extraction'
            ],
            [
                'key' => 'withdrawal_fee_percentage',
                'value' => '5.00',
                'type' => 'decimal',
                'group' => 'payment',
                'description' => 'System audit fee for withdrawals'
            ],
            [
                'key' => 'max_daily_withdrawal',
                'value' => '50000.00',
                'type' => 'decimal',
                'group' => 'payment',
                'description' => 'Daily threshold for capital outflow'
            ],

            // Operational Protocol
            [
                'key' => 'platform_service_fee',
                'value' => '2.00',
                'type' => 'decimal',
                'group' => 'system',
                'description' => 'Global operational maintenance fee'
            ],
            [
                'key' => 'kyc_auto_approve_limit',
                'value' => '1000.00',
                'type' => 'decimal',
                'group' => 'system',
                'description' => 'Threshold for automated node validation'
            ]
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
