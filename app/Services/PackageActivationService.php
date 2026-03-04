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

        // Example "Self-Logic": Upgrade user status based on package name or price
        // This is where specific MLM logic or feature unlocks happen.
        
        $oldStatus = $user->status;
        $newStatus = $user->status;

        // Simple mapping for demonstration - can be expanded
        if (str_contains(strtolower($product->name), 'bp')) {
            $newStatus = 'bp';
        } elseif (str_contains(strtolower($product->name), 'merchant')) {
            $newStatus = 'merchant';
        } elseif (str_contains(strtolower($product->name), 'rider')) {
            $newStatus = 'rider';
        }

        if ($newStatus !== $oldStatus) {
            $user->update(['status' => $newStatus]);
            $user->syncRoles([$newStatus]);
            
            $this->auditService->log('package_activated', $user, 
                ['status' => $oldStatus], 
                ['status' => $newStatus, 'package_id' => $product->id, 'order_id' => $order->id]
            );
        }

        // Additional Logic: Maybe generate referral links, etc.
    }
}
