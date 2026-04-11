<?php

use Illuminate\Support\Facades\Route;
use Modules\Ecommerce\Http\Controllers\HomeController;
use Modules\Ecommerce\Http\Controllers\ProductController;
use Modules\Ecommerce\Http\Controllers\CartController;
use Modules\Ecommerce\Http\Controllers\CheckoutController;
use Modules\Ecommerce\Http\Controllers\OrderController;
use Modules\Ecommerce\Http\Controllers\WalletController;
use Modules\Ecommerce\Http\Controllers\ReferralController;
use Modules\Ecommerce\Http\Controllers\InvestmentController;
use Modules\Ecommerce\Http\Controllers\RegionalDashboardController;
use Modules\Ecommerce\Http\Controllers\InvoiceController;
use Modules\Ecommerce\Http\Controllers\KycController;
use Modules\Ecommerce\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public e-commerce routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/merchants', [HomeController::class, 'merchants'])->name('merchants.index');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/quick-view', [ProductController::class, 'quickView'])->name('products.quick-view');

// Public Order Tracking
Route::get('/track-order', [OrderController::class, 'trackForm'])->name('orders.track-form');
Route::get('/tracking', [OrderController::class, 'track'])->name('orders.track');

// Categories
Route::get('/categories', function() {
    $categories = \App\Models\Category::where('is_active', true)
        ->whereNull('parent_id')
        ->withCount('products')
        ->with(['children' => function($q) {
            $q->withCount('products')->with('children');
        }])
        ->orderBy('sort_order')
        ->get();
    return view('ecommerce::categories.index', compact('categories'));
})->name('categories.index');

// Cart summary (public — used by mini-cart in header)
Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');

// Auth Required Routes
Route::middleware(['auth'])->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout
    Route::middleware(['wallet_verified'])->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
        Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
    });
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Wallet
    Route::middleware(['wallet_verified'])->group(function () {
        Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
        Route::get('/wallet/preview-recipient', [WalletController::class, 'previewRecipient'])->name('wallet.preview-recipient');
        Route::post('/wallet/transfer', [WalletController::class, 'transfer'])->name('wallet.transfer');
    });
    
    // Referral system
    Route::post('/referral/generate', [ReferralController::class, 'generateCode'])->name('referral.generate');
    Route::get('/referrals', [ReferralController::class, 'myReferrals'])->name('referrals.index');
    
    // Investment & Shares (Phase 6)
    Route::middleware(['wallet_verified'])->prefix('investments')->name('investments.')->group(function () {
        Route::get('/', [InvestmentController::class, 'index'])->name('index');
        Route::get('/my-shares', [InvestmentController::class, 'myShares'])->name('my-shares');
        Route::get('/{shop}', [InvestmentController::class, 'show'])->name('show');
        Route::post('/{shop}/purchase', [InvestmentController::class, 'purchase'])->name('purchase');
    });

    // Regional Management (Phase 3)
    Route::middleware(['role:upazila|district|division|director'])->prefix('regional')->name('regional.')->group(function () {
        Route::get('/dashboard', [RegionalDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [RegionalDashboardController::class, 'users'])->name('users');
        Route::get('/orders', [RegionalDashboardController::class, 'orders'])->name('orders');
    });

    // Invoices
    Route::get('/invoices/{order}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/invoices/{order}/view', [InvoiceController::class, 'view'])->name('invoices.view');

    // KYC
    Route::get('/kyc', [KycController::class, 'index'])->name('kyc.index');
    Route::post('/kyc', [KycController::class, 'store'])->name('kyc.store');
});

// Payments
Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate')->middleware('auth');
Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
