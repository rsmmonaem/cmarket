<?php $__env->startSection('title', 'Payout Pipeline - CMarket'); ?>
<?php $__env->startSection('page-title', 'Withdrawal Processing Terminal'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary & Financial Logic -->
    <div class="bg-slate-900 dark:bg-slate-900 rounded-[3rem] p-10 lg:p-12 text-white shadow-2xl shadow-slate-900/10 flex flex-col lg:flex-row justify-between items-center gap-10 overflow-hidden relative group">
        <div class="relative z-10">
            <h2 class="text-3xl font-black text-white tracking-tight leading-none mb-4">Payout Pipeline</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] ml-1">Managing Global Liquidity Outflows • <?php echo e(number_format($withdrawals->total())); ?> Logged Requests</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 relative z-10 w-full lg:w-auto">
            <div class="px-6 py-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-center">
                <div class="text-[8px] font-black text-amber-500 uppercase tracking-widest mb-1">Queued</div>
                <div class="text-xl font-black text-white"><?php echo e(number_format($stats['pending'])); ?></div>
            </div>
            <div class="px-6 py-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-center">
                <div class="text-[8px] font-black text-emerald-500 uppercase tracking-widest mb-1">Success</div>
                <div class="text-xl font-black text-white"><?php echo e(number_format($stats['approved'])); ?></div>
            </div>
            <div class="px-6 py-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-center">
                <div class="text-[8px] font-black text-rose-500 uppercase tracking-widest mb-1">Declined</div>
                <div class="text-xl font-black text-white"><?php echo e(number_format($stats['rejected'])); ?></div>
            </div>
            <div class="px-6 py-5 rounded-2xl bg-sky-500 text-white text-center shadow-xl shadow-sky-500/20">
                <div class="text-[8px] font-black text-white/60 uppercase tracking-widest mb-1">Disbursed</div>
                <div class="text-xl font-black text-white">৳<?php echo e(number_format($stats['total_disbursed'] / 1000, 1)); ?>k</div>
            </div>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">PAYOUT</div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Beneficiary Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Financial Quantum</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Gateway</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Protocol Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-900 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:scale-110 transition-transform">
                                        <?php echo e(substr($withdrawal->wallet->user->name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1"><?php echo e($withdrawal->wallet->user->name); ?></div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest"><?php echo e($withdrawal->wallet->user->phone); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-lg font-black text-slate-900 dark:text-white leading-none mb-1">৳<?php echo e(number_format($withdrawal->amount, 2)); ?></div>
                                <div class="text-[9px] font-black text-sky-500 uppercase tracking-widest">Source: <?php echo e($withdrawal->wallet->wallet_type); ?> Reservoir</div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-[9px] font-black text-slate-800 dark:text-white uppercase tracking-widest">
                                    <?php echo e(str_replace('_', ' ', $withdrawal->payment_method)); ?>

                                </span>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <?php if($withdrawal->status === 'pending'): ?>
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-amber-50 text-amber-600 border border-amber-100">
                                        <span class="w-1 h-1 rounded-full bg-amber-500 animate-pulse"></span> QUEUED
                                    </span>
                                <?php elseif($withdrawal->status === 'approved'): ?>
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        SUCCESS
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-rose-50 text-rose-600 border border-rose-100">
                                        DECLINED
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="<?php echo e(route('admin.withdrawals.show', $withdrawal)); ?>" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[9px] font-black uppercase tracking-[0.2em] shadow-xl shadow-slate-900/10 hover:bg-sky-500 transition-all flex items-center gap-2">
                                        Review ⚡
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">💸</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Queue Neutralized</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($withdrawals->hasPages()): ?>
            <div class="p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                <?php echo e($withdrawals->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/admin/withdrawals/index.blade.php ENDPATH**/ ?>