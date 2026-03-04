<?php $__env->startSection('title', 'Order Stream - CMarket'); ?>
<?php $__env->startSection('page-title', 'Global Commerce Stream'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Territory Commerce</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Live Transaction Stream • <?php echo e(number_format($orders->total())); ?> Logged Events</p>
        </div>
        <div class="grid grid-cols-2 lg:flex items-center gap-3 md:gap-4 relative z-10 w-full lg:w-auto">
            <div class="px-4 py-4 md:px-8 md:py-6 rounded-2xl md:rounded-3xl bg-slate-900 dark:bg-sky-600 shadow-2xl shadow-slate-900/10 dark:shadow-sky-500/10 text-center flex-1">
                <div class="text-[7px] md:text-[8px] font-black text-sky-400 dark:text-white uppercase tracking-widest mb-1">Total Revenue</div>
                <div class="text-base md:text-xl font-black text-white">৳<?php echo e(number_format($orders->where('status', 'delivered')->sum('total_amount') / 1000, 1)); ?>k</div>
            </div>
            <div class="px-4 py-4 md:px-8 md:py-6 rounded-2xl md:rounded-3xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-center flex-1 shadow-sm">
                <div class="text-[7px] md:text-[8px] font-black text-amber-500 uppercase tracking-widest mb-1">Active Queue</div>
                <div class="text-base md:text-xl font-black text-slate-800 dark:text-white"><?php echo e($orders->where('status', 'pending')->count() + $orders->where('status', 'processing')->count()); ?></div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">COMMERCE</div>
    </div>

    <!-- Intelligent Filtering Terminal -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 border border-slate-100 dark:border-slate-800 shadow-sm">
        <form method="GET" class="flex flex-col lg:flex-row gap-4 md:gap-6">
            <div class="flex-1 relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 opacity-20 text-lg">🔍</span>
                <input type="text" name="search" placeholder="Search order sequence or token..." 
                       value="<?php echo e(request('search')); ?>"
                       class="w-full h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-16 pr-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600">
            </div>
            
            <div class="lg:w-64">
                <select name="status" class="w-full h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all">
                    <option value="">All Lifecycle Phases</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="paid" <?php echo e(request('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                    <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Processing</option>
                    <option value="shipped" <?php echo e(request('status') == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                    <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </div>
            
            <button type="submit" class="h-14 md:h-16 px-10 bg-slate-900 dark:bg-sky-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-sky-600 dark:hover:bg-sky-500 transition-all flex items-center justify-center gap-3 active:scale-95 shadow-lg shadow-slate-900/10 dark:shadow-sky-500/10">
                Execute Filter
            </button>
        </form>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Order Token</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Target Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Merchant Entity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Transaction Value</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Lifecycle</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="text-sm font-black text-slate-800 dark:text-white mb-1">#<?php echo e($order->order_number); ?></div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest"><?php echo e($order->created_at->format('d M Y • h:i A')); ?></div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1"><?php echo e($order->user->name); ?></div>
                                <div class="text-[9px] text-sky-500 font-bold tracking-tighter"><?php echo e($order->user->phone); ?></div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white line-clamp-1 max-w-[150px]"><?php echo e($order->merchant->business_name ?? 'N/A'); ?></div>
                                <div class="text-[8px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">Protocol Partner</div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div class="text-sm font-black text-slate-800 dark:text-white leading-none mb-1">৳<?php echo e(number_format($order->total_amount, 2)); ?></div>
                                <div class="text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest"><?php echo e($order->payment_method); ?></div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <?php
                                    $statusStyles = [
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'paid' => 'bg-sky-50 text-sky-600 border-sky-100',
                                        'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'shipped' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    ];
                                    $styleClass = $statusStyles[$order->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                ?>
                                <span class="inline-flex py-1.5 px-3 rounded-lg text-[8px] font-black border uppercase <?php echo e($styleClass); ?>">
                                    <?php echo e($order->status); ?>

                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-xl hover:bg-sky-500 transition-all shadow-xl shadow-slate-900/20">
                                        👁️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">📦</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Zero Commerce Events Located</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($orders->hasPages()): ?>
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>