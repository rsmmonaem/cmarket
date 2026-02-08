<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // KYC Management
            'view kyc',
            'approve kyc',
            'reject kyc',
            
            // Wallet Management
            'view wallets',
            'manage wallets',
            'approve withdrawals',
            
            // Product Management
            'view products',
            'create products',
            'edit products',
            'delete products',
            
            // Order Management
            'view orders',
            'manage orders',
            'cancel orders',
            
            // Merchant Management
            'view merchants',
            'approve merchants',
            'suspend merchants',
            
            // Rider Management
            'view riders',
            'manage riders',
            
            // Commission Management
            'view commissions',
            'approve commissions',
            'configure commission rules',
            
            // Designation Management
            'view designations',
            'create designations',
            'edit designations',
            'delete designations',
            
            // Reports
            'view reports',
            'export reports',
            
            // Settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin - all permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - most permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view kyc', 'approve kyc', 'reject kyc',
            'view wallets', 'approve withdrawals',
            'view products', 'view orders', 'manage orders',
            'view merchants', 'approve merchants',
            'view riders', 'manage riders',
            'view commissions', 'approve commissions',
            'view reports', 'export reports',
        ]);

        // Merchant - product and order management
        $merchant = Role::create(['name' => 'merchant']);
        $merchant->givePermissionTo([
            'view products', 'create products', 'edit products',
            'view orders',
        ]);

        // Rider - delivery management
        $rider = Role::create(['name' => 'rider']);
        $rider->givePermissionTo([
            'view orders',
        ]);

        // Customer - basic permissions
        $customer = Role::create(['name' => 'customer']);
        $customer->givePermissionTo([
            'view products',
        ]);
    }
}
