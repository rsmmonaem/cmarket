<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('designations')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $designations = [
            ['name' => 'Base Partner', 'percentage' => 80.00, 'points' => 1000, 'order' => 1],
            ['name' => 'Agent', 'percentage' => 11.00, 'points' => 5000, 'order' => 2],
            ['name' => 'Brand Promoter', 'percentage' => 3.00, 'points' => 18000, 'order' => 3],
            ['name' => 'Marketing Executive', 'percentage' => 2.00, 'points' => 0, 'order' => 4, 'targets' => true],
            ['name' => 'Executive', 'percentage' => 1.50, 'points' => 0, 'order' => 5, 'targets' => true],
            ['name' => 'Business Leader', 'percentage' => 1.00, 'points' => 0, 'order' => 6, 'targets' => true],
            ['name' => 'Branch Manager', 'percentage' => 0.75, 'points' => 0, 'order' => 7, 'targets' => true],
            ['name' => 'Regional Manager', 'percentage' => 0.50, 'points' => 0, 'order' => 8, 'targets' => true],
            ['name' => 'Executive Director', 'percentage' => 0.25, 'points' => 0, 'order' => 9, 'targets' => true],
        ];

        foreach ($designations as $d) {
            \App\Models\Designation::create([
                'name' => $d['name'],
                'slug' => \Illuminate\Support\Str::slug($d['name']),
                'percentage' => $d['percentage'],
                'required_points' => $d['points'],
                'required_voucher_points' => $d['points'], // typically equal for upgrade
                'sales_target' => isset($d['targets']) ? 50000 * $d['order'] : 0, 
                'referral_target' => isset($d['targets']) ? 5 * $d['order'] : 0,
                'team_building_target' => isset($d['targets']) ? 10 * $d['order'] : 0,
                'criteria' => json_encode([]),
                'commission_rate' => 0,
                'sort_order' => $d['order'],
                'is_active' => true,
            ]);
        }
    }
}
