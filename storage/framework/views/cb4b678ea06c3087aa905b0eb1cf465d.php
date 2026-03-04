<?php $__env->startSection('title', 'Designation Management'); ?>
<?php $__env->startSection('page-title', 'Platform Hierarchies'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginalad5130b5347ab6ecc017d2f5a278b926 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad5130b5347ab6ecc017d2f5a278b926 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-xl font-black text-light">Company Designations</h2>
            <p class="text-xs text-muted-light font-bold uppercase tracking-widest">Define roles and achievement ranks</p>
        </div>
        <a href="<?php echo e(route('admin.designations.create')); ?>">
            <?php if (isset($component)) { $__componentOriginal60a020e5340f3f52bbc4501dc9f93102 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal60a020e5340f3f52bbc4501dc9f93102 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <span class="text-lg">➕</span> Add New Rank
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal60a020e5340f3f52bbc4501dc9f93102)): ?>
<?php $attributes = $__attributesOriginal60a020e5340f3f52bbc4501dc9f93102; ?>
<?php unset($__attributesOriginal60a020e5340f3f52bbc4501dc9f93102); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal60a020e5340f3f52bbc4501dc9f93102)): ?>
<?php $component = $__componentOriginal60a020e5340f3f52bbc4501dc9f93102; ?>
<?php unset($__componentOriginal60a020e5340f3f52bbc4501dc9f93102); ?>
<?php endif; ?>
        </a>
    </div>

    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Rank Title</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Required Sales</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Required Team</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Benefit %</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                <?php $__empty_1 = true; $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-lg">
                                    <?php echo e(substr($designation->name, 0, 1)); ?>

                                </div>
                                <div>
                                    <div class="text-sm font-black text-light"><?php echo e($designation->name); ?></div>
                                    <div class="text-[10px] text-muted-light font-bold">LVL: <?php echo e($designation->level ?? 1); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-light">
                            ৳<?php echo e(number_format($designation->min_sales ?? 0, 0)); ?>

                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-light">
                             <?php echo e($designation->min_team_size ?? 0); ?> MEMBERS
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg bg-sky-50 dark:bg-sky-900/20 text-sky-600 dark:text-sky-400 font-black text-xs">
                                <?php echo e($designation->commission_rate ?? 0); ?>%
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('admin.designations.edit', $designation)); ?>" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-sky-500 hover:text-white transition shadow-sm">
                                    ✏️
                                </a>
                                <form action="<?php echo e(route('admin.designations.destroy', $designation)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this rank?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-red-500 hover:text-white transition shadow-sm">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted-light italic">No designations defined yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/admin/designations/index.blade.php ENDPATH**/ ?>