<?php $__env->startSection('title', 'Browse Categories - CMarket'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-indigo-900 py-16 text-white text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">All Categories</h1>
        <p class="text-indigo-200 text-lg">Explore our diverse range of products across all departments</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="group relative bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 hover:shadow-indigo-900/10 transition-all duration-500 border border-gray-100 hover:border-indigo-100 flex flex-col items-center text-center">
                <div class="w-24 h-24 mb-6 rounded-full overflow-hidden bg-gray-50 flex items-center justify-center group-hover:scale-110 transition duration-500 shadow-inner">
                    <?php if($category->image): ?>
                        <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span class="text-4xl text-indigo-300">📦</span>
                    <?php endif; ?>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition"><?php echo e($category->name); ?></h3>
                <p class="text-gray-500 text-sm mb-6 line-clamp-2"><?php echo e($category->description ?? 'Explore premium products in ' . $category->name); ?></p>
                
                <div class="mt-auto">
                    <span class="inline-block bg-indigo-50 text-indigo-700 text-xs font-bold px-4 py-1.5 rounded-full mb-6">
                        <?php echo e($category->products_count ?? 0); ?> PRODUCTS
                    </span>
                    
                    <a href="<?php echo e(route('products.index', ['category' => $category->id])); ?>" class="block w-full text-indigo-600 font-bold border-2 border-indigo-600 px-6 py-2.5 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all transform group-hover:scale-105 shadow-lg shadow-indigo-600/5">
                        Browse Now
                    </a>
                </div>
                
                <?php if($category->children->count() > 0): ?>
                    <div class="mt-8 pt-6 border-t border-gray-100 w-full text-left">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Sub-Categories</span>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('products.index', ['category' => $child->id])); ?>" class="text-xs bg-gray-100 hover:bg-indigo-100 text-gray-600 hover:text-indigo-700 px-3 py-1 rounded-lg transition">
                                    <?php echo e($child->name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full py-24 text-center">
                <div class="text-6xl mb-6">🏜️</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No Categories Found</h2>
                <p class="text-gray-500">We're adding new categories soon. Check back later!</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/categories/index.blade.php ENDPATH**/ ?>