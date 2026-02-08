<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Merchant\DashboardController as MerchantDashboardController;
use App\Http\Controllers\Rider\DashboardController as RiderDashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public e-commerce routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

// Products
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories', function() { return view('categories.index'); })->name('categories.index');

// Cart (requires auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{product}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    
    // Orders
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    
    // Wallet
    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    
    // Referral system
    Route::post('/referral/generate', [App\Http\Controllers\ReferralController::class, 'generateCode'])->name('referral.generate');
    Route::get('/referrals', [App\Http\Controllers\ReferralController::class, 'myReferrals'])->name('referrals.index');
    
    // Invoices
    Route::get('/invoices/{order}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/invoices/{order}/view', [App\Http\Controllers\InvoiceController::class, 'view'])->name('invoices.view');
});

// Merchant registration (public)
Route::get('/merchant/register', [App\Http\Controllers\Merchant\MerchantRegistrationController::class, 'showRegistrationForm'])->name('merchant.register');
Route::post('/merchant/register', [App\Http\Controllers\Merchant\MerchantRegistrationController::class, 'register'])->name('merchant.register.submit')->middleware('auth');

// Rider registration (public)
Route::get('/rider/register', [App\Http\Controllers\Rider\RiderRegistrationController::class, 'showRegistrationForm'])->name('rider.register');
Route::post('/rider/register', [App\Http\Controllers\Rider\RiderRegistrationController::class, 'register'])->name('rider.register.submit')->middleware('auth');

// OTP Authentication
Route::get('/login/otp', [App\Http\Controllers\Auth\OtpAuthController::class, 'showLoginForm'])->name('login.otp');
Route::post('/login/otp/send', [App\Http\Controllers\Auth\OtpAuthController::class, 'sendOtp'])->name('login.otp.send');
Route::post('/login/otp/verify', [App\Http\Controllers\Auth\OtpAuthController::class, 'verifyOtp'])->name('login.otp.verify');
Route::post('/login/otp/resend', [App\Http\Controllers\Auth\OtpAuthController::class, 'resendOtp'])->name('login.otp.resend');

// Payment Gateway
Route::post('/payment/initiate', [App\Http\Controllers\PaymentController::class, 'initiate'])->name('payment.initiate')->middleware('auth');
Route::post('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
Route::post('/payment/fail', [App\Http\Controllers\PaymentController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [App\Http\Controllers\PaymentController::class, 'ipn'])->name('payment.ipn');

// Affiliate program
Route::get('/affiliate/register', function() { return view('affiliate.register'); })->name('affiliate.register');


// Customer dashboard (all authenticated users)
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
});

// Merchant dashboard
Route::middleware(['auth', 'role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/dashboard', [MerchantDashboardController::class, 'index'])->name('dashboard');
    
    // Product management
    Route::resource('products', App\Http\Controllers\Merchant\ProductController::class);
    
    // Order management
    Route::get('/orders', [App\Http\Controllers\Merchant\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Merchant\OrderController::class, 'show'])->name('orders.show');
    
    // Reports
    Route::get('/reports/sales', [App\Http\Controllers\Merchant\ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/export', [App\Http\Controllers\Merchant\ReportController::class, 'exportExcel'])->name('reports.sales.export');
});

// Rider dashboard
Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/dashboard', [RiderDashboardController::class, 'index'])->name('dashboard');
    
    // Delivery management
    Route::get('/deliveries', [App\Http\Controllers\Rider\DeliveryController::class, 'index'])->name('deliveries.index');
    Route::get('/deliveries/{delivery}', [App\Http\Controllers\Rider\DeliveryController::class, 'show'])->name('deliveries.show');
    Route::post('/deliveries/{delivery}/update-status', [App\Http\Controllers\Rider\DeliveryController::class, 'updateStatus'])->name('deliveries.update-status');
});

// Admin routes
Route::middleware(['auth', 'role:super-admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // KYC management
    Route::get('kyc', [App\Http\Controllers\Admin\KycController::class, 'index'])->name('kyc.index');
    Route::get('kyc/{kyc}', [App\Http\Controllers\Admin\KycController::class, 'show'])->name('kyc.show');
    Route::post('kyc/{kyc}/approve', [App\Http\Controllers\Admin\KycController::class, 'approve'])->name('kyc.approve');
    Route::post('kyc/{kyc}/reject', [App\Http\Controllers\Admin\KycController::class, 'reject'])->name('kyc.reject');
    
    // Wallet management
    Route::get('wallets', [App\Http\Controllers\Admin\WalletController::class, 'index'])->name('wallets.index');
    Route::get('wallets/{wallet}', [App\Http\Controllers\Admin\WalletController::class, 'show'])->name('wallets.show');
    Route::post('wallets/{wallet}/credit', [App\Http\Controllers\Admin\WalletController::class, 'credit'])->name('wallets.credit');
    Route::post('wallets/{wallet}/debit', [App\Http\Controllers\Admin\WalletController::class, 'debit'])->name('wallets.debit');
    Route::post('wallets/{wallet}/lock', [App\Http\Controllers\Admin\WalletController::class, 'lock'])->name('wallets.lock');
    Route::post('wallets/{wallet}/unlock', [App\Http\Controllers\Admin\WalletController::class, 'unlock'])->name('wallets.unlock');
    
    // Withdrawal management
    Route::get('withdrawals', [App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('withdrawals/{withdrawal}', [App\Http\Controllers\Admin\WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('withdrawals/{withdrawal}/approve', [App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('withdrawals/{withdrawal}/reject', [App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');
    
    // Category management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Product management
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    
    // Order management
    Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{order}/cancel', [App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Merchant management
    Route::get('merchants', [App\Http\Controllers\Admin\MerchantController::class, 'index'])->name('merchants.index');
    Route::get('merchants/{merchant}', [App\Http\Controllers\Admin\MerchantController::class, 'show'])->name('merchants.show');
    Route::post('merchants/{merchant}/approve', [App\Http\Controllers\Admin\MerchantController::class, 'approve'])->name('merchants.approve');
    Route::post('merchants/{merchant}/reject', [App\Http\Controllers\Admin\MerchantController::class, 'reject'])->name('merchants.reject');
    Route::post('merchants/{merchant}/suspend', [App\Http\Controllers\Admin\MerchantController::class, 'suspend'])->name('merchants.suspend');
    
    // Rider management
    Route::get('riders', [App\Http\Controllers\Admin\RiderController::class, 'index'])->name('riders.index');
    Route::get('riders/{rider}', [App\Http\Controllers\Admin\RiderController::class, 'show'])->name('riders.show');
    Route::post('riders/{rider}/approve', [App\Http\Controllers\Admin\RiderController::class, 'approve'])->name('riders.approve');
    Route::post('riders/{rider}/reject', [App\Http\Controllers\Admin\RiderController::class, 'reject'])->name('riders.reject');
    Route::post('riders/{rider}/suspend', [App\Http\Controllers\Admin\RiderController::class, 'suspend'])->name('riders.suspend');
    
    // Commission management
    Route::get('commissions', [App\Http\Controllers\Admin\CommissionController::class, 'index'])->name('commissions.index');
    Route::get('commissions/{commission}', [App\Http\Controllers\Admin\CommissionController::class, 'show'])->name('commissions.show');
    Route::post('commissions/{commission}/approve', [App\Http\Controllers\Admin\CommissionController::class, 'approve'])->name('commissions.approve');
    Route::post('commissions/{commission}/reject', [App\Http\Controllers\Admin\CommissionController::class, 'reject'])->name('commissions.reject');
    Route::post('commissions/bulk-approve', [App\Http\Controllers\Admin\CommissionController::class, 'bulkApprove'])->name('commissions.bulk-approve');
    
    // Designation management
    Route::resource('designations', App\Http\Controllers\Admin\DesignationController::class);
});
