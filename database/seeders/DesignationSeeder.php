<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('designations')->truncate();
        Schema::enableForeignKeyConstraints();

        $designations = [
            [
                'name' => 'BP (Business Partner)',
                'description' => 'Entry level designation protocol',
                'criteria' => ['sales_count' => 10, 'referral_count' => 5, 'team_levels' => 1],
                'commission_rate' => 1.0,
                'percentage' => 1.0,
                'required_points' => 1000,
                'required_voucher_points' => 1000,
                'sort_order' => 1,
            ],
            [
                'name' => 'ME (Marketing Executive)',
                'description' => 'Mid-level operational lead',
                'criteria' => ['sales_count' => 50, 'referral_count' => 20, 'team_levels' => 2],
                'commission_rate' => 2.0,
                'percentage' => 2.0,
                'required_points' => 5000,
                'required_voucher_points' => 5000,
                'sort_order' => 2,
            ],
            [
                'name' => 'BC (Business Coordinator)',
                'description' => 'Senior management node',
                'criteria' => ['sales_count' => 100, 'referral_count' => 50, 'team_levels' => 3],
                'commission_rate' => 3.0,
                'percentage' => 3.0,
                'required_points' => 15000,
                'required_voucher_points' => 15000,
                'sort_order' => 3,
            ],
            [
                'name' => 'Upazila Manager',
                'description' => 'Regional administrative director (Sub-district)',
                'criteria' => ['sales_count' => 200, 'referral_count' => 100, 'team_levels' => 4],
                'commission_rate' => 4.0,
                'percentage' => 4.0,
                'required_points' => 50000,
                'required_voucher_points' => 50000,
                'sort_order' => 4,
            ],
            [
                'name' => 'District Manager',
                'description' => 'District level protocol supervisor',
                'criteria' => ['sales_count' => 500, 'referral_count' => 250, 'team_levels' => 5],
                'commission_rate' => 5.0,
                'percentage' => 5.0,
                'required_points' => 150000,
                'required_voucher_points' => 150000,
                'sort_order' => 5,
            ],
            [
                'name' => 'Division Manager',
                'description' => 'Division level ecosystem controller',
                'criteria' => ['sales_count' => 1000, 'referral_count' => 500, 'team_levels' => 6],
                'commission_rate' => 6.0,
                'percentage' => 6.0,
                'required_points' => 500000,
                'required_voucher_points' => 500000,
                'sort_order' => 6,
            ],
            [
                'name' => 'Director',
                'description' => 'Top tier strategic architect',
                'criteria' => ['sales_count' => 2000, 'referral_count' => 1000, 'team_levels' => 7],
                'commission_rate' => 7.0,
                'percentage' => 7.0,
                'required_points' => 1500000,
                'required_voucher_points' => 1500000,
                'sort_order' => 7,
            ],
        ];

        foreach ($designations as $d) {
            Designation::create(array_merge($d, [
                'slug' => Str::slug($d['name']),
                'is_active' => true,
            ]));
        }
    }
}
