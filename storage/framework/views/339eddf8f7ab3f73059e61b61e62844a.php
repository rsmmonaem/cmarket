<?php $__env->startSection('title', 'Admin Command - CMarket'); ?>
<?php $__env->startSection('page-title', 'Global Overview'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-10 animate-fade-in">
    <!-- Macro Infrastructure Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Users Logic -->
        <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['class' => 'relative overflow-hidden group border-none bg-slate-900 text-white shadow-2xl shadow-slate-900/10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'relative overflow-hidden group border-none bg-slate-900 text-white shadow-2xl shadow-slate-900/10']); ?>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] opacity-40">User Base Hub</span>
                    <span class="text-xl">👥</span>
                </div>
                <h3 class="text-4xl font-black mb-2 tracking-tighter"><?php echo e(number_format(\App\Models\User::count())); ?></h3>
                <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">+<?php echo e(\App\Models\User::where('created_at', '>=', now()->subDays(7))->count()); ?> growth last 7d</p>
            </div>
            <!-- Background element -->
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-8xl font-black italic">USERS</div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $attributes = $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $component = $__componentOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>

        <!-- KYC Verification Pipeline -->
        <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['class' => 'relative overflow-hidden group border-none bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'relative overflow-hidden group border-none bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-500']); ?>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">KYC Auth Pipeline</span>
                    <span class="text-xl">🛡️</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-2 tracking-tighter"><?php echo e(number_format(\App\Models\Kyc::where('status', 'pending')->count())); ?></h3>
                <p class="text-[9px] font-black text-rose-500 uppercase tracking-widest">Awaiting Manual Audit</p>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-8xl font-black italic text-slate-400 dark:text-white">AUTH</div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $attributes = $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $component = $__componentOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>

        <!-- Order Fulfillment -->
        <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['class' => 'relative overflow-hidden group border-none bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'relative overflow-hidden group border-none bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-500']); ?>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Orders Deployed</span>
                    <span class="text-xl">🛍️</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-2 tracking-tighter"><?php echo e(number_format(\App\Models\Order::count())); ?></h3>
                <p class="text-[9px] font-black text-sky-500 uppercase tracking-widest">Active Lifecycle</p>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-8xl font-black italic text-slate-400 dark:text-white">ORDERS</div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $attributes = $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $component = $__componentOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>

        <!-- Financial Outflow -->
        <?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => ['class' => 'relative overflow-hidden group border-none bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'relative overflow-hidden group border-none bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-500']); ?>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Pending Withdrawals</span>
                    <span class="text-xl">💸</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-2 tracking-tighter"><?php echo e(number_format(\App\Models\Withdrawal::where('status', 'pending')->count())); ?></h3>
                <p class="text-[9px] font-black text-amber-500 uppercase tracking-widest">Liquidity Request Queue</p>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-8xl font-black italic text-slate-400 dark:text-white">CASH</div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $attributes = $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__attributesOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926)): ?>
<?php $component = $__componentOriginalad5130b5347ab6ecc017d2f5a278b926; ?>
<?php unset($__componentOriginalad5130b5347ab6ecc017d2f5a278b926); ?>
<?php endif; ?>
    </div>

    <!-- Active Intel Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Order Stream -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-6 md:px-10 py-6 md:py-8 border-b border-slate-50 dark:border-slate-800 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-slate-50/30 dark:bg-slate-800/30">
                    <div>
                        <h3 class="text-xs md:text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest">Territory Activity Stream</h3>
                        <p class="text-[8px] md:text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase mt-1">Real-time order synchronization</p>
                    </div>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-[9px] font-black text-sky-500 uppercase tracking-widest hover:text-slate-900 dark:hover:text-white transition-colors">Global Log →</a>
                </div>

                <div class="divide-y divide-slate-50 dark:divide-slate-800">
                    <?php $recentOrders = \App\Models\Order::with('user')->latest()->take(7)->get(); ?>
                    <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-6 md:p-8 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group">
                            <div class="flex items-center gap-4 md:gap-6">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-lg md:text-xl shadow-sm group-hover:scale-110 transition-transform">📦</div>
                                <div>
                                    <h4 class="text-xs md:text-sm font-black text-slate-800 dark:text-white">#<?php echo e($order->order_number); ?></h4>
                                    <p class="text-[8px] md:text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest"><?php echo e($order->user->name ?? 'Protocol Guest'); ?></p>
                                </div>
                            </div>
                            <div class="text-right flex items-center gap-4 md:gap-8">
                                <div class="hidden sm:block">
                                    <p class="text-[8px] md:text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase mb-1">Valuation</p>
                                    <p class="text-xs md:text-sm font-black text-slate-900 dark:text-white">৳<?php echo e(number_format($order->total_amount, 0)); ?></p>
                                </div>
                                <div class="w-24 md:w-32 text-right">
                                    <span class="px-2 md:px-3 py-1 rounded-lg text-[7px] md:text-[8px] font-black uppercase tracking-wider
                                        <?php if($order->status === 'paid' || $order->status === 'delivered'): ?> bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400
                                        <?php elseif($order->status === 'pending'): ?> bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400
                                        <?php else: ?> bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 <?php endif; ?>">
                                        <?php echo e($order->status); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="py-20 text-center opacity-20">
                            <span class="text-6xl mb-6 flex justify-center">🧊</span>
                            <p class="text-xs font-black uppercase tracking-widest">No Recent Stream Activity</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- System Utilities -->
        <div class="space-y-8">
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-10 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-10 pl-1">Protocol Utility Shortcuts</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="<?php echo e(route('admin.kyc.index')); ?>" class="p-6 rounded-3xl bg-slate-900 dark:bg-slate-800 text-white hover:bg-sky-600 dark:hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10 flex flex-col items-center text-center gap-4">
                        <span class="text-3xl">🛡️</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">KYC Audit</span>
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="p-6 rounded-3xl bg-indigo-600 text-white hover:bg-sky-600 transition-all shadow-xl shadow-indigo-600/10 flex flex-col items-center text-center gap-4">
                        <span class="text-3xl">👥</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">User Base</span>
                    </a>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="p-6 rounded-3xl border-2 border-slate-50 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all flex flex-col items-center text-center gap-4 group/btn">
                        <span class="text-3xl grayscale group-hover/btn:grayscale-0 transition-all">📦</span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">Inventory</span>
                    </a>
                    <a href="<?php echo e(route('admin.wallets.index')); ?>" class="p-6 rounded-3xl border-2 border-slate-50 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all flex flex-col items-center text-center gap-4 group/btn">
                        <span class="text-3xl grayscale group-hover/btn:grayscale-0 transition-all">💰</span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">Cash Flow</span>
                    </a>
                </div>
            </div>

            <!-- Global Configuration Shortcut -->
            <div class="bg-gradient-to-br from-rose-500 to-indigo-600 rounded-[2.5rem] p-10 text-white relative overflow-hidden group shadow-2xl shadow-indigo-500/20">
                <div class="relative z-10">
                    <h4 class="text-xl font-black mb-2 leading-tight">System Core Hub</h4>
                    <p class="text-xs font-bold text-white/60 mb-8 leading-relaxed">Configure global variables, API integrations and security protocols.</p>
                    
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="inline-flex items-center gap-3 px-6 py-4 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-white/20 transition-all">
                        Edit System Control ⚡
                    </a>
                </div>
                <!-- Decor -->
                <div class="absolute -right-6 -bottom-6 opacity-10 text-[180px] select-none italic font-black">CORE</div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>