<?php $__env->startSection('title', 'Marketplace - CMarket'); ?>
<?php $__env->startSection('page-title', 'Marketplace'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col lg:flex-row gap-10 animate-fade-in">
    <!-- Intelligent Filtering Sidebar -->
    <aside class="w-full lg:w-[320px] flex-shrink-0 space-y-8">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm sticky top-32">
            <div class="flex items-center gap-3 mb-10 pl-1">
                <span class="text-xl">🔍</span>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Refine Catalog</h3>
            </div>
            
            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="space-y-8">
                <!-- Search -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Search Keywords</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Product name..." class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Category Hub</label>
                    <select name="category" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        <option value="">All Dynamic Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Monetary Reach</label>
                    <div class="flex gap-4">
                        <input type="number" name="min_price" placeholder="Min" value="<?php echo e(request('min_price')); ?>" class="w-1/2 bg-slate-50 border-none rounded-2xl p-4 text-xs font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300">
                        <input type="number" name="max_price" placeholder="Max" value="<?php echo e(request('max_price')); ?>" class="w-1/2 bg-slate-50 border-none rounded-2xl p-4 text-xs font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <!-- Sorting -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Sorting Priority</label>
                    <select name="sort" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Latest Acquisitions</option>
                        <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Value: Ascending</option>
                        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Value: Descending</option>
                        <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Nomenclature</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-slate-900/10 hover:bg-sky-600 hover:scale-[1.02] transition-all duration-300">
                    Update Results ✨
                </button>
                <a href="<?php echo e(route('products.index')); ?>" class="block text-center text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Reset Global Filters</a>
            </form>
        </div>
    </aside>

    <!-- Global Product Infrastructure -->
    <div class="flex-1 space-y-8">
        <!-- Results Summary -->
        <div class="flex items-center justify-between px-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                Identified <span class="text-slate-800"><?php echo e($products->total()); ?></span> Assets in Territory
            </p>
        </div>

        <!-- Catalog Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col">
                    <!-- Visual Asset Container -->
                    <div class="aspect-square relative overflow-hidden bg-slate-50">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <?php else: ?>
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-50 group-hover:bg-sky-50 transition-colors">
                                <span class="text-5xl mb-2 opacity-20">📦</span>
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Visual Pending</span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Badges -->
                        <div class="absolute top-6 right-6 flex flex-col gap-2">
                            <?php if($product->cashback_percentage): ?>
                                <div class="px-3 py-1 bg-emerald-500 text-white rounded-full text-[9px] font-black uppercase tracking-wider shadow-lg shadow-emerald-500/20">
                                    <?php echo e($product->cashback_percentage); ?>% Cashback
                                </div>
                            <?php endif; ?>
                            <?php if($product->points > 0): ?>
                                <div class="px-3 py-1 bg-sky-500 text-white rounded-full text-[9px] font-black uppercase tracking-wider shadow-lg shadow-sky-500/20">
                                    +<?php echo e($product->points); ?> Points
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Descriptive Block -->
                    <div class="p-8 flex-1 flex flex-col">
                        <p class="text-[9px] font-black text-sky-500 uppercase tracking-widest mb-2"><?php echo e($product->category->name); ?></p>
                        <h3 class="text-lg font-black text-slate-800 mb-6 leading-tight group-hover:text-sky-600 transition-colors line-clamp-2 min-h-[3rem]">
                            <a href="<?php echo e(route('products.show', $product)); ?>"><?php echo e($product->name); ?></a>
                        </h3>
                        
                        <div class="mt-auto space-y-6">
                            <!-- Monetary Evaluation -->
                            <div class="flex items-baseline gap-3">
                                <?php if($product->discount_price): ?>
                                    <span class="text-3xl font-black text-slate-900 tracking-tighter">৳<?php echo e(number_format($product->discount_price, 0)); ?></span>
                                    <span class="text-sm font-bold text-slate-300 line-through">৳<?php echo e(number_format($product->price, 0)); ?></span>
                                <?php else: ?>
                                    <span class="text-3xl font-black text-slate-900 tracking-tighter">৳<?php echo e(number_format($product->price, 0)); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Contextual Metadata -->
                            <div class="flex items-center justify-between border-t border-slate-50 pt-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full <?php echo e($product->stock > 10 ? 'bg-emerald-500' : 'bg-rose-500'); ?>"></div>
                                    <span class="text-[10px] font-black text-slate-400 capitalize"><?php echo e($product->stock > 0 ? $product->stock . ' units available' : 'Out of stock'); ?></span>
                                </div>
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-tighter">By <?php echo e($product->merchant->business_name); ?></span>
                            </div>

                            <!-- Engagement Module -->
                            <button onclick="addToCart(<?php echo e($product->id); ?>)" class="w-full py-4 bg-slate-50 text-slate-900 rounded-2xl border-2 border-transparent font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:shadow-xl hover:shadow-slate-900/10 transition-all duration-300 flex items-center justify-center gap-3">
                                <span>🛒</span> Add to Terminal
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-32 flex flex-col items-center text-center">
                    <div class="text-8xl mb-8 opacity-10">🧊</div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase tracking-widest mb-2">Zero Assets Identified</h3>
                    <p class="text-sm font-bold text-slate-400">Expansion of inventory is required to match your criteria.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Infrastructure Pagination -->
        <?php if($products->hasPages()): ?>
            <div class="pt-10">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function addToCart(productId) {
    <?php if(auth()->guard()->guest()): ?>
        window.location.href = '<?php echo e(route("login")); ?>';
        return;
    <?php endif; ?>
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Toast.fire({
                icon: 'success',
                title: 'Item added to cart! 🛍️'
            });
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.fire({
                icon: 'error',
                title: data.message || 'Fulfillment error.'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Protocol failure.'
        });
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/products/index.blade.php ENDPATH**/ ?>