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
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin - all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin - most permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
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
        $merchant = Role::firstOrCreate(['name' => 'merchant']);
        $merchant->syncPermissions([
            'view products', 'create products', 'edit products',
            'view orders',
        ]);

        // Rider - delivery management
        $rider = Role::firstOrCreate(['name' => 'rider']);
        $rider->syncPermissions([
            'view orders',
        ]);

        // Customer - basic permissions
        $customer = Role::firstOrCreate(['name' => 'customer']);
        $customer->syncPermissions([
            'view products',
        ]);

        // Ecosystem Roles
        $roles = [
            'wallet_verified', 'bp', 'me', 'bc', 
            'upazila', 'district', 'division', 'director'
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions([
                'view products',
                'view reports', // Area-wise reports for higher roles
            ]);
        }
    }
}
