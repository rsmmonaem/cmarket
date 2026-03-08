<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\DashboardController;

Route::middleware(['auth', 'role:super-admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User management
    Route::resource('users', \Modules\Admin\Http\Controllers\UserController::class);
    Route::get('users/{user}/generations', [\Modules\Admin\Http\Controllers\UserController::class, 'generations'])->name('users.generations');
    
    // KYC management
    Route::get('kyc', [\Modules\Admin\Http\Controllers\KycController::class, 'index'])->name('kyc.index');
    Route::get('kyc/{kyc}', [\Modules\Admin\Http\Controllers\KycController::class, 'show'])->name('kyc.show');
    Route::post('kyc/{kyc}/approve', [\Modules\Admin\Http\Controllers\KycController::class, 'approve'])->name('kyc.approve');
    Route::post('kyc/{kyc}/reject', [\Modules\Admin\Http\Controllers\KycController::class, 'reject'])->name('kyc.reject');
    
    // Wallet management
    Route::get('wallets', [\Modules\Admin\Http\Controllers\WalletController::class, 'index'])->name('wallets.index');
    Route::get('wallets/{wallet}', [\Modules\Admin\Http\Controllers\WalletController::class, 'show'])->name('wallets.show');
    Route::post('wallets/{wallet}/credit', [\Modules\Admin\Http\Controllers\WalletController::class, 'credit'])->name('wallets.credit');
    Route::post('wallets/{wallet}/debit', [\Modules\Admin\Http\Controllers\WalletController::class, 'debit'])->name('wallets.debit');
    Route::post('wallets/{wallet}/lock', [\Modules\Admin\Http\Controllers\WalletController::class, 'lock'])->name('wallets.lock');
    Route::post('wallets/{wallet}/unlock', [\Modules\Admin\Http\Controllers\WalletController::class, 'unlock'])->name('wallets.unlock');
    
    // Withdrawal management
    Route::get('withdrawals', [\Modules\Admin\Http\Controllers\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('withdrawals/{withdrawal}', [\Modules\Admin\Http\Controllers\WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('withdrawals/{withdrawal}/approve', [\Modules\Admin\Http\Controllers\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('withdrawals/{withdrawal}/reject', [\Modules\Admin\Http\Controllers\WithdrawalController::class, 'reject'])->name('withdrawals.reject');
    
    // Banner management
    Route::patch('banners/{banner}/toggle-status', [\Modules\Admin\Http\Controllers\BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::resource('banners', \Modules\Admin\Http\Controllers\BannerController::class);

    // Category management
    Route::patch('categories/{category}/toggle-status', [\Modules\Admin\Http\Controllers\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::get('sub-categories', [\Modules\Admin\Http\Controllers\CategoryController::class, 'index'])->name('sub-categories.index');
    Route::get('sub-sub-categories', [\Modules\Admin\Http\Controllers\CategoryController::class, 'index'])->name('sub-sub-categories.index');
    Route::resource('categories', \Modules\Admin\Http\Controllers\CategoryController::class);
    
    // POS
    Route::get('pos', [\Modules\Admin\Http\Controllers\PosController::class, 'index'])->name('pos.index');

    // Brands & Attributes
    Route::resource('brands', \Modules\Admin\Http\Controllers\BrandController::class);
    Route::resource('attributes', \Modules\Admin\Http\Controllers\AttributeController::class);

    // Product management
    Route::resource('products', \Modules\Admin\Http\Controllers\ProductController::class);
    
    // Order management
    Route::get('orders', [\Modules\Admin\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\Modules\Admin\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/update-status', [\Modules\Admin\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{order}/cancel', [\Modules\Admin\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Refund Management
    Route::get('refunds', [\Modules\Admin\Http\Controllers\RefundController::class, 'index'])->name('refunds.index');

    // Promotions
    Route::resource('coupons', \Modules\Admin\Http\Controllers\CouponController::class);
    Route::resource('flash-deals', \Modules\Admin\Http\Controllers\FlashDealController::class);
    
    // Merchant management
    Route::get('merchants', [\Modules\Admin\Http\Controllers\MerchantController::class, 'index'])->name('merchants.index');
    Route::get('merchants/{merchant}', [\Modules\Admin\Http\Controllers\MerchantController::class, 'show'])->name('merchants.show');
    Route::post('merchants/{merchant}/approve', [\Modules\Admin\Http\Controllers\MerchantController::class, 'approve'])->name('merchants.approve');
    Route::post('merchants/{merchant}/reject', [\Modules\Admin\Http\Controllers\MerchantController::class, 'reject'])->name('merchants.reject');
    Route::post('merchants/{merchant}/suspend', [\Modules\Admin\Http\Controllers\MerchantController::class, 'suspend'])->name('merchants.suspend');
    
    // Rider management
    Route::get('riders', [\Modules\Admin\Http\Controllers\RiderController::class, 'index'])->name('riders.index');
    Route::get('riders/{rider}', [\Modules\Admin\Http\Controllers\RiderController::class, 'show'])->name('riders.show');
    Route::post('riders/{rider}/approve', [\Modules\Admin\Http\Controllers\RiderController::class, 'approve'])->name('riders.approve');
    Route::post('riders/{rider}/reject', [\Modules\Admin\Http\Controllers\RiderController::class, 'reject'])->name('riders.reject');
    Route::post('riders/{rider}/suspend', [\Modules\Admin\Http\Controllers\RiderController::class, 'suspend'])->name('riders.suspend');
    
    // Commission management
    Route::get('commissions', [\Modules\Admin\Http\Controllers\CommissionController::class, 'index'])->name('commissions.index');
    Route::get('commissions/{commission}', [\Modules\Admin\Http\Controllers\CommissionController::class, 'show'])->name('commissions.show');
    Route::post('commissions/{commission}/approve', [\Modules\Admin\Http\Controllers\CommissionController::class, 'approve'])->name('commissions.approve');
    Route::post('commissions/{commission}/reject', [\Modules\Admin\Http\Controllers\CommissionController::class, 'reject'])->name('commissions.reject');
    Route::post('commissions/bulk-approve', [\Modules\Admin\Http\Controllers\CommissionController::class, 'bulkApprove'])->name('commissions.bulk-approve');
    
    // Designation management
    Route::resource('designations', \Modules\Admin\Http\Controllers\DesignationController::class);

    // System Settings
    Route::get('settings', [\Modules\Admin\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\Modules\Admin\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [\Modules\Admin\Http\Controllers\ReportController::class, 'sales'])->name('sales');
        Route::get('/merchants', [\Modules\Admin\Http\Controllers\ReportController::class, 'merchants'])->name('merchants');
        Route::get('/financials', [\Modules\Admin\Http\Controllers\ReportController::class, 'financials'])->name('financials');
        Route::get('/orders', [\Modules\Admin\Http\Controllers\ReportController::class, 'orders'])->name('orders');
    });

    // Chart JSON API for live dashboard data
    Route::get('/api/chart-data', function (\Illuminate\Http\Request $request) {
        $period = $request->get('period', 'week');
        $days   = match($period) { 'year' => 365, 'month' => 30, default => 7 };

        $data = \App\Models\Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')->orderBy('date')->get();

        return response()->json([
            'labels'   => $data->pluck('date'),
            'revenue'  => $data->pluck('revenue'),
            'orders'   => $data->pluck('orders'),
        ]);
    })->name('api.chart-data');

    // POS receipt view
    Route::get('/pos/receipt/{order}', function (\App\Models\Order $order) {
        $order->load(['items', 'user']);
        return view('admin::pos.receipt', compact('order'));
    })->name('pos.receipt');
});
