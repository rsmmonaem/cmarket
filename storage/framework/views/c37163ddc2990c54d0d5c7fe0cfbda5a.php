<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'EcomMatrix - Global Multi-Merchant Marketplace'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'EcomMatrix is a premium global multi-merchant marketplace infrastructure for modern commerce.'); ?>">
    <?php echo $__env->yieldPushContent('meta'); ?>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f97316', // Orange accent
                        'primary-hover': '#ea580c',
                        surface: '#ffffff',
                        background: '#f8fafc',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    borderRadius: {
                        '4xl': '2rem',
                    }
                }
            }
        }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .gradient-orange { background: linear-gradient(135deg, #f97316 0%, #fb923c 100%); }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-background text-slate-900 font-sans selection:bg-primary selection:text-white">
    <!-- Top Bar -->
    <div class="bg-slate-900 text-white py-2.5 px-4 sm:px-6 lg:px-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto flex justify-between items-center text-[10px] sm:text-[11px] font-bold uppercase tracking-widest">
            <div class="flex items-center gap-6">
                <span class="hidden md:flex items-center gap-2">
                    <span class="text-primary text-sm">📞</span> +880 1700-000000
                </span>
                <div class="flex items-center gap-4">
                    <select class="bg-transparent border-none focus:ring-0 cursor-pointer hover:text-primary transition-colors pr-4">
                        <option class="text-slate-900">English</option>
                        <option class="text-slate-900">Bangla</option>
                    </select>
                </div>
            </div>
            
            <div class="hidden lg:block">
                <span class="animate-pulse bg-primary/20 text-primary px-3 py-1 rounded-full text-[9px]">
                    🔥 FREE SHIPPING ON ORDERS OVER ৳1000
                </span>
            </div>

            <div class="flex items-center gap-6">
                <a href="<?php echo e(route('merchant.register')); ?>" class="hover:text-primary transition-colors">Seller Zone</a>
                <a href="#" class="hover:text-primary transition-colors">Order Tracker</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-5">
            <div class="flex items-center justify-between gap-6 lg:gap-12">
                <!-- Logo -->
                <a href="<?php echo e(route('home')); ?>" class="flex-shrink-0 flex items-center gap-2 group">
                    <div class="w-10 h-10 gradient-orange rounded-xl flex items-center justify-center text-white text-xl shadow-lg shadow-orange-500/20 group-hover:rotate-12 transition-transform">
                        🧩
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-slate-900">Ecom<span class="text-primary">Matrix</span></span>
                </a>

                <!-- Intelligent Search Bar -->
                <div class="flex-1 max-w-2xl hidden md:block group">
                    <form action="<?php echo e(route('products.search')); ?>" method="GET" class="relative">
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="What are you looking for today?" 
                               class="w-full bg-slate-100 border-none rounded-2xl py-4.5 pl-6 pr-16 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-12 h-12 bg-primary text-white rounded-xl flex items-center justify-center hover:bg-primary-hover transition-all shadow-lg shadow-orange-500/20 active:scale-95">
                            <span class="text-xl">🔍</span>
                        </button>
                    </form>
                </div>

                <!-- Strategic Icons -->
                <div class="flex items-center gap-3 md:gap-8">
                    <?php if(auth()->guard()->check()): ?>
                        <div class="relative group/user">
                            <a href="<?php echo e(route('customer.dashboard')); ?>" class="flex flex-col items-center gap-1 group hover:text-primary transition-colors">
                                <span class="text-2xl opacity-80 group-hover:opacity-100">👤</span>
                                <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block">My Matrix</span>
                            </a>
                            <!-- Hover Dropdown Mini -->
                            <div class="absolute right-0 top-full pt-4 opacity-0 invisible group-hover/user:opacity-100 group-hover/user:visible transition-all duration-300">
                                <div class="bg-white rounded-2xl shadow-2xl border border-slate-50 p-6 min-w-[220px]">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Node Profile</p>
                                    <div class="space-y-3">
                                        <a href="<?php echo e(route('customer.dashboard')); ?>" class="block text-sm font-bold text-slate-700 hover:text-primary transition-colors">Dashboard Overview</a>
                                        <a href="<?php echo e(route('orders.index')); ?>" class="block text-sm font-bold text-slate-700 hover:text-primary transition-colors">Order History</a>
                                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin|admin')): ?>
                                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block text-sm font-bold text-primary hover:text-primary-hover">System Terminal</a>
                                        <?php endif; ?>
                                        <hr class="border-slate-50 my-2">
                                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="w-full text-left text-sm font-black text-rose-500 uppercase tracking-widest pt-2">Kill Session</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="flex flex-col items-center gap-1 group hover:text-primary transition-colors">
                            <span class="text-2xl opacity-80 group-hover:opacity-100">🔑</span>
                            <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block">Access Node</span>
                        </a>
                    <?php endif; ?>

                    <a href="#" class="flex flex-col items-center gap-1 group hover:text-primary transition-colors relative">
                        <span class="text-2xl opacity-80 group-hover:opacity-100">🤍</span>
                        <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block">Wishlist</span>
                    </a>

                    <a href="<?php echo e(route('cart.index')); ?>" class="flex flex-col items-center gap-1 group hover:text-primary transition-colors relative">
                        <span class="text-2xl opacity-80 group-hover:opacity-100">🛒</span>
                        <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block">Basket</span>
                        <?php if(session('cart_count', 0) > 0): ?>
                            <span class="absolute -top-1 -right-2 bg-primary text-white text-[9px] font-black rounded-full w-5 h-5 flex items-center justify-center border-2 border-white shadow-lg shadow-orange-500/20">
                                <?php echo e(session('cart_count', 0)); ?>

                            </span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
            
            <!-- Mobile Search Matrix -->
            <div class="mt-4 md:hidden">
                <form action="<?php echo e(route('products.search')); ?>" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Search our marketplace..." 
                           class="w-full bg-slate-100 border-none rounded-xl py-3.5 pl-5 pr-12 focus:ring-2 focus:ring-primary/20 transition-all text-sm font-medium">
                    <button type="submit" class="absolute right-0 top-0 h-full px-4 text-primary text-xl">🔍</button>
                </form>
            </div>
        </div>

        <!-- Global Navigation Hierarchy -->
        <nav class="bg-slate-50 border-t border-slate-100 hidden lg:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center gap-8 h-12">
                    <div class="relative group/cat h-full">
                        <button class="flex items-center gap-3 bg-primary text-white px-8 h-full font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-orange-500/10 active:scale-95 transition-transform">
                            <span>☰</span> Browse Matrix
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-8 h-full">
                        <a href="<?php echo e(route('home')); ?>" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group <?php echo e(request()->routeIs('home') ? 'text-primary' : ''); ?>">
                            Home
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full <?php echo e(request()->routeIs('home') ? 'opacity-100' : 'opacity-0'); ?> group-hover:opacity-100 transition-opacity"></span>
                        </a>
                        <a href="#" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group">
                            Brands
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full opacity-0 group-hover:opacity-100 transition-all"></span>
                        </a>
                        <a href="<?php echo e(route('products.index')); ?>" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group">
                            Flash Deals
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full opacity-0 group-hover:opacity-100 transition-all"></span>
                        </a>
                        <a href="<?php echo e(route('merchants.index')); ?>" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group">
                            All Merchants
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full opacity-0 group-hover:opacity-100 transition-all"></span>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    <a href="<?php echo e(route('merchant.register')); ?>" class="text-[10px] font-black text-primary uppercase tracking-[0.2em] hover:brightness-110">
                        🚀 Start Selling
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Content Matrix -->
    <main class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Global Footer Matrix -->
    <footer class="bg-slate-900 text-white mt-32 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 opacity-5 pointer-events-none translate-x-1/2 -translate-y-1/2">
            <span class="text-[400px] font-black italic">MATRIX</span>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16">
                <!-- Brand Info -->
                <div class="space-y-8">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3">
                        <div class="w-10 h-10 gradient-orange rounded-xl flex items-center justify-center text-white text-xl">
                            🧩
                        </div>
                        <span class="text-2xl font-black tracking-tighter">Ecom<span class="text-primary">Matrix</span></span>
                    </a>
                    <p class="text-slate-400 text-sm font-medium leading-[2] max-w-xs">
                        The ultimate high-fidelity multi-merchant marketplace platform. Built for global scale and professional commerce operations.
                    </p>
                    <div class="flex gap-4">
                        <?php $__currentLoopData = ['FB', 'TW', 'IG', 'YT']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-400 hover:bg-primary hover:text-white transition-all cursor-pointer shadow-lg shadow-black/20">
                                <?php echo e($sc); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Navigation Nodes -->
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-10 text-primary">Marketplace Hierarchy</h4>
                    <ul class="space-y-5 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <li><a href="<?php echo e(route('products.index')); ?>" class="hover:text-white transition-colors">Global Inventory</a></li>
                        <li><a href="<?php echo e(route('categories.index')); ?>" class="hover:text-white transition-colors">Taxonomy Nodes</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="hover:text-white transition-colors">Mission Protocol</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-white transition-colors">Comm Terminal</a></li>
                    </ul>
                </div>

                <!-- Strategic Pipelines -->
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-10 text-primary">Merchant Operations</h4>
                    <ul class="space-y-5 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <li><a href="<?php echo e(route('merchant.register')); ?>" class="hover:text-white transition-colors">Merchant Onboarding</a></li>
                        <li><a href="<?php echo e(route('rider.register')); ?>" class="hover:text-white transition-colors">Logistical Network</a></li>
                        <li><a href="<?php echo e(route('affiliate.register')); ?>" class="hover:text-white transition-colors">Affiliate Nodes</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Seller Protocol</a></li>
                    </ul>
                </div>

                <!-- Newsletter Node -->
                <div class="space-y-8">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-10 text-primary">Newsletter Protocol</h4>
                    <p class="text-slate-400 text-xs font-bold">STAY SYNCHRONIZED WITH LATEST RELEASES</p>
                    <form class="flex flex-col gap-4">
                        <input type="email" placeholder="Enter session email" 
                               class="bg-slate-800 border-none rounded-xl px-6 py-4 text-xs font-bold focus:ring-4 focus:ring-primary/20 placeholder:text-slate-500">
                        <button type="submit" class="bg-primary hover:bg-primary-hover px-10 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-orange-500/10 active:scale-95 transition-all">
                            Initialize Link
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-slate-800/50 mt-24 pt-12 flex flex-col lg:flex-row justify-between items-center gap-10 text-slate-500 text-[9px] font-black uppercase tracking-[0.2em]">
                <div class="flex items-center gap-4">
                    <span>&copy; <?php echo e(date('Y')); ?> EcomMatrix Infrastructure.</span>
                    <span class="hidden md:block opacity-20">|</span>
                    <span class="hidden md:block">ALL RIGHTS SECURED</span>
                </div>
                
                <div class="flex gap-12">
                    <a href="#" class="hover:text-white transition-colors">Privacy Encryption</a>
                    <a href="#" class="hover:text-white transition-colors">Service Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Cookie Data</a>
                </div>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/layouts/public.blade.php ENDPATH**/ ?>