<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MLMTestSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Admin (Receiver of Admin Profit)
        $admin = User::firstOrCreate(
            ['email' => 'admin@cmarket.local'],
            [
                'name' => 'System Admin',
                'phone' => '01000000000',
                'password' => Hash::make('password'),
                'status' => 'verified'
            ]
        );
        
        // Assign role safely
        if (Role::where('name', 'admin')->exists()) {
             $admin->assignRole('admin');
        }
        
        if (!$admin->hasWallet('main')) {
            $admin->wallets()->create(['wallet_type' => 'main']);
        }

        // 2. Create the Upline Chain (13 Users: Top Parent down to Subscriber's Parent)
        // Total 14 users in chain: Top -> ... -> Parent -> Subscriber
        
        $prevUser = null;
        for ($i = 1; $i <= 13; $i++) {
            $user = User::updateOrCreate(
                ['email' => "upline{$i}@cmarket.local"],
                [
                    'name' => "Upline Level {$i}",
                    'phone' => '01' . str_pad($i, 9, '0', STR_PAD_LEFT),
                    'password' => Hash::make('password'),
                    'referred_by' => $prevUser ? $prevUser->id : null,
                    'status' => 'verified'
                ]
            );

            // Ensure wallets exist
            if (!$user->hasWallet('main')) {
                $user->wallets()->create(['wallet_type' => 'main']);
            }
            if (!$user->hasWallet('commission')) {
                $user->wallets()->create(['wallet_type' => 'commission']);
            }

            $prevUser = $user;
        }

        // 3. Create the Test Subscriber (The one who buys the card)
        $subscriber = User::updateOrCreate(
            ['email' => 'subscriber@cmarket.local'],
            [
                'name' => 'Test Subscriber',
                'phone' => '01999999999',
                'password' => Hash::make('password'),
                'referred_by' => $prevUser->id,
                'status' => 'verified'
            ]
        );

        // Give subscriber money to buy the card
        $subWallet = $subscriber->wallets()->where('wallet_type', 'main')->first();
        if (!$subWallet) {
            $subWallet = $subscriber->wallets()->create(['wallet_type' => 'main']);
        }
        
        // Add 2000 BDT to subscriber wallet (Enough for 1000 BDT card)
        if ($subWallet->balance < 1000) {
            $subWallet->credit(2000, 'TEST-' . time(), 'topup', 'Initial testing balance');
        }

        $this->command->info('MLM Test Chain Created!');
        $this->command->info('Subscriber: subscriber@cmarket.local (Password: password)');
        $this->command->info('Direct Parent: ' . $prevUser->email);
        $this->command->info('Admin: ' . $admin->email);
    }
}
