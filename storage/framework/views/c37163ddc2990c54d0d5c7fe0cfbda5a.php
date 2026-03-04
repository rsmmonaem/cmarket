<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'CMarket - Your Online Shopping Destination'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-indigo-600">
                        🛒 CMarket
                    </a>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Home</a>
                        <a href="<?php echo e(route('products.index')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Products</a>
                        <a href="<?php echo e(route('categories.index')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Categories</a>
                        <a href="<?php echo e(route('about')); ?>" class="text-gray-700 hover:text-indigo-600 px-3 py-2">About</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <form action="<?php echo e(route('products.search')); ?>" method="GET" class="hidden md:block">
                        <input type="text" name="q" placeholder="Search products..." 
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </form>

                    <!-- Cart -->
                    <a href="<?php echo e(route('cart.index')); ?>" class="relative text-gray-700 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(session('cart_count', 0) > 0): ?>
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    <?php echo e(session('cart_count', 0)); ?>

                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>

                    <!-- User Menu -->
                    <?php if(auth()->guard()->check()): ?>
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                                <span><?php echo e(Auth::user()->name); ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin|admin')): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                <?php endif; ?>
                                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'merchant')): ?>
                                    <a href="<?php echo e(route('merchant.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Merchant Dashboard</a>
                                <?php endif; ?>
                                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'rider')): ?>
                                    <a href="<?php echo e(route('rider.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Rider Dashboard</a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('customer.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Dashboard</a>
                                <a href="<?php echo e(route('orders.index')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Orders</a>
                                <a href="<?php echo e(route('wallet.index')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Wallet</a>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">CMarket</h3>
                    <p class="text-gray-400">Your trusted online shopping destination with cashback rewards and referral benefits.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?php echo e(route('products.index')); ?>" class="hover:text-white">Products</a></li>
                        <li><a href="<?php echo e(route('categories.index')); ?>" class="hover:text-white">Categories</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="hover:text-white">About Us</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">For Business</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?php echo e(route('merchant.register')); ?>" class="hover:text-white">Become a Merchant</a></li>
                        <li><a href="<?php echo e(route('rider.register')); ?>" class="hover:text-white">Become a Rider</a></li>
                        <li><a href="<?php echo e(route('affiliate.register')); ?>" class="hover:text-white">Affiliate Program</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>📧 support@cmarket.com</li>
                        <li>📞 +880 1700-000000</li>
                        <li>📍 Dhaka, Bangladesh</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?php echo e(date('Y')); ?> CMarket. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/layouts/public.blade.php ENDPATH**/ ?>