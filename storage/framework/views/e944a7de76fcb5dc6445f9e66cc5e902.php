<?php $__env->startSection('title', 'Welcome Back - CMarket'); ?>
<?php $__env->startSection('page-title', 'Overview'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8 animate-fade-in">
    <!-- Quick Stats Hub -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Balance Card -->
        <div class="bg-slate-900 rounded-[2rem] p-6 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4 opacity-70">
                    <span class="text-lg">👛</span>
                    <span class="text-[10px] font-black uppercase tracking-widest">Main Wallet</span>
                </div>
                <h3 class="text-3xl font-black mb-1">৳<?php echo e(number_format($user->getWallet('main')?->balance ?? 0, 2)); ?></h3>
                <p class="text-[10px] font-medium text-sky-400">Available for Purchases</p>
            </div>
            <div class="absolute -right-6 -bottom-6 opacity-10 text-8xl group-hover:scale-110 transition-transform duration-500">💰</div>
        </div>

        <!-- Commission Card -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4 text-emerald-600">
                    <span class="text-lg">📈</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Earnings</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1">৳<?php echo e(number_format($user->getWallet('commission')?->balance ?? 0, 2)); ?></h3>
                <p class="text-[10px] font-medium text-emerald-500">+12% from last week</p>
            </div>
            <div class="absolute -right-6 -bottom-6 opacity-5 text-8xl group-hover:scale-110 transition-transform duration-500">💎</div>
        </div>

        <!-- Points Card -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4 text-amber-500">
                    <span class="text-lg">🔥</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Reward Points</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1"><?php echo e(number_format($user->points)); ?></h3>
                <p class="text-[10px] font-medium text-amber-500">Lifetime: <?php echo e(number_format($user->total_points)); ?></p>
            </div>
            <div class="absolute -right-6 -bottom-6 opacity-5 text-8xl group-hover:scale-110 transition-transform duration-500">⭐</div>
        </div>

        <!-- Voucher Card -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4 text-indigo-500">
                    <span class="text-lg">🎫</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Voucher Points</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1"><?php echo e(number_format($user->voucher_points)); ?></h3>
                <p class="text-[10px] font-medium text-indigo-500">Ready for Upgrades</p>
            </div>
            <div class="absolute -right-6 -bottom-6 opacity-5 text-8xl group-hover:scale-110 transition-transform duration-500">🎟️</div>
        </div>
    </div>

    <!-- Main Dashboard Body -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Career Status -->
            <?php
                $currentRank = $user->currentDesignation?->designation;
                $nextRank = \App\Models\Designation::where('sort_order', '>', $currentRank?->sort_order ?? 0)->orderBy('sort_order', 'asc')->first();
                $progress = 0;
                if ($nextRank && $nextRank->required_points > 0) {
                    $progress = min(100, ($user->total_points / $nextRank->required_points) * 100);
                }
            ?>

            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-500">Career Trajectory</h3>
                    <span class="px-4 py-1.5 rounded-full bg-sky-500 text-white text-[10px] font-black uppercase tracking-wider shadow-lg shadow-sky-500/20">
                        <?php echo e($currentRank?->name ?? 'Free Customer'); ?>

                    </span>
                </div>

                <?php if($nextRank): ?>
                <div class="space-y-6">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Next Goal</p>
                            <h4 class="text-xl font-black text-slate-800"><?php echo e($nextRank->name); ?></h4>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-black text-sky-600"><?php echo e(number_format($user->total_points)); ?> <span class="text-xs text-slate-400">/ <?php echo e(number_format($nextRank->required_points)); ?></span></p>
                        </div>
                    </div>
                    <div class="relative h-4 bg-slate-100 rounded-full overflow-hidden">
                        <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-sky-400 to-sky-600 rounded-full transition-all duration-1000" style="width: <?php echo e($progress); ?>%"></div>
                    </div>
                    
                    <!-- Voucher Upgrade Ad -->
                    <div class="mt-8 p-6 rounded-3xl bg-indigo-600 text-white relative overflow-hidden shadow-xl shadow-indigo-600/20 group">
                        <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div class="text-center sm:text-left">
                                <h5 class="text-lg font-black leading-tight">Fast-Track Upgrade Available</h5>
                                <p class="text-xs font-bold opacity-80 mt-1">Upgrade using <?php echo e(number_format($nextRank->required_voucher_points)); ?> Voucher Points instantly.</p>
                            </div>
                            <form action="<?php echo e(route('customer.upgrade.voucher')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="required_points" value="<?php echo e($nextRank->required_voucher_points); ?>">
                                <?php if($user->voucher_points >= $nextRank->required_voucher_points): ?>
                                    <button type="submit" class="px-8 py-4 rounded-2xl bg-white text-indigo-600 text-xs font-black uppercase tracking-widest hover:scale-105 transition shadow-xl">Activate Upgrade</button>
                                <?php else: ?>
                                    <button type="button" disabled class="px-8 py-4 rounded-2xl bg-white/20 text-white/50 text-xs font-black uppercase tracking-widest cursor-not-allowed">Insufficient Points</button>
                                <?php endif; ?>
                            </form>
                        </div>
                        <div class="absolute -right-6 -bottom-6 opacity-10 text-9xl rotate-12 group-hover:rotate-0 transition-all">🚀</div>
                    </div>
                </div>
                <?php else: ?>
                    <div class="flex flex-col items-center py-10 text-center">
                        <span class="text-6xl mb-4">👑</span>
                        <h4 class="text-2xl font-black text-slate-800">Elite Level Reached</h4>
                        <p class="text-sm text-slate-500 font-bold mt-2">You have reached the maximum career designation.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent Activity Placeholder -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-500">Recent Activity</h3>
                    <a href="<?php echo e(route('orders.index')); ?>" class="text-[10px] font-black text-sky-600 hover:text-sky-700">SEE ALL →</a>
                </div>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $user->orders()->latest()->take(3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center">🛍️</div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">Order #<?php echo e($order->order_number); ?></p>
                                    <p class="text-[10px] font-bold text-slate-400"><?php echo e($order->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-slate-800">৳<?php echo e(number_format($order->total_amount, 2)); ?></p>
                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded <?php echo e($order->status == 'delivered' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500'); ?>"><?php echo e($order->status); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-10 opacity-30">
                            <p class="text-sm font-black uppercase tracking-widest">No recent activity</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <aside class="space-y-8">
            <!-- KYC Card -->
            <?php if(!$user->kyc || $user->kyc->status !== 'approved'): ?>
            <div class="bg-amber-50 rounded-[2.5rem] p-8 border border-amber-100 relative overflow-hidden">
                <h3 class="text-sm font-black text-amber-800 uppercase tracking-widest mb-4">Identity Unverified</h3>
                <p class="text-xs font-bold text-amber-900/60 leading-relaxed mb-8">Complete your KYC verification to unlock full system features including withdrawals and hierarchy earnings.</p>
                <a href="<?php echo e(route('kyc.index')); ?>" class="w-full py-4 rounded-2xl bg-amber-500 text-white font-black text-xs uppercase tracking-widest text-center block shadow-lg shadow-amber-500/20 hover:scale-[1.02] transition">Verify Now ⚡</a>
                <div class="absolute -right-4 -bottom-4 text-8xl opacity-5 select-none font-black italic">!</div>
            </div>
            <?php endif; ?>

            <!-- Portal Shortcuts -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <h3 class="text-sm font-black text-slate-500 uppercase tracking-widest mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="<?php echo e(route('products.index')); ?>" class="p-4 rounded-3xl bg-slate-50 text-center hover:bg-slate-100 transition group">
                        <span class="text-2xl block mb-2 group-hover:scale-110 transition-transform">📦</span>
                        <span class="text-[10px] font-black uppercase tracking-tight text-slate-700">Shop</span>
                    </a>
                    <a href="<?php echo e(route('wallet.index')); ?>" class="p-4 rounded-3xl bg-slate-50 text-center hover:bg-slate-100 transition group">
                        <span class="text-2xl block mb-2 group-hover:scale-110 transition-transform">💳</span>
                        <span class="text-[10px] font-black uppercase tracking-tight text-slate-700">Wallet</span>
                    </a>
                    <a href="<?php echo e(route('referrals.index')); ?>" class="p-4 rounded-3xl bg-slate-50 text-center hover:bg-slate-100 transition group">
                        <span class="text-2xl block mb-2 group-hover:scale-110 transition-transform">🤝</span>
                        <span class="text-[10px] font-black uppercase tracking-tight text-slate-700">Network</span>
                    </a>
                    <a href="<?php echo e(route('investments.index')); ?>" class="p-4 rounded-3xl bg-slate-50 text-center hover:bg-slate-100 transition group">
                        <span class="text-2xl block mb-2 group-hover:scale-110 transition-transform">🏗️</span>
                        <span class="text-[10px] font-black uppercase tracking-tight text-slate-700">Invest</span>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/customer/dashboard.blade.php ENDPATH**/ ?>