<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class PackageActivationService
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Activate package features for a user based on an order
     */
    public function activate(Order $order)
    {
        $user = $order->user;
        
        foreach ($order->items as $item) {
            $product = $item->product;
            
            if ($product && $product->type === 'package') {
                $this->processPackage($user, $product, $order);
            }
        }
    }

    /**
     * Core logic for package activation (Self-Logic)
     */
    protected function processPackage(User $user, Product $product, Order $order)
    {
        Log::info("Processing package activation for User ID: {$user->id}, Package: {$product->name}");

        $oldStatus = $user->status;
        $newStatus = $user->status;
        $updateData = [];

        // 1. Determine Status Upgrade
        if (str_contains(strtolower($product->name), 'bp')) {
            $newStatus = 'bp';
        } elseif (str_contains(strtolower($product->name), 'merchant')) {
            $newStatus = 'merchant';
        } elseif (str_contains(strtolower($product->name), 'rider')) {
            $newStatus = 'rider';
        } elseif (str_contains(strtolower($product->name), 'membership')) {
            // Membership Card Specific Logic
            $newStatus = 'verified';
            $updateData['has_membership_card'] = true;
            $updateData['membership_purchased_at'] = now();

            // Generate Unique Member ID if not exists
            if (!$user->member_id) {
                $lastUser = User::whereNotNull('member_id')->orderBy('member_id', 'desc')->first();
                $lastIdNumber = 10000;

                if ($lastUser && preg_match('/CAB(\d+)/', $lastUser->member_id, $matches)) {
                    $lastIdNumber = (int)$matches[1];
                }

                $updateData['member_id'] = 'CAB' . ($lastIdNumber + 1);
            }
        }

        // 2. Apply Updates
        if ($newStatus !== $oldStatus || !empty($updateData)) {
            $updateData['status'] = $newStatus;
            $user->update($updateData);
            
            // Sync roles if status changed
            if ($newStatus !== $oldStatus) {
                $user->syncRoles([$newStatus]);
            }
            
            $this->auditService->log('package_activated', $user, 
                ['status' => $oldStatus], 
                array_merge($updateData, ['package_id' => $product->id, 'order_id' => $order->id])
            );
        }
    }
}
