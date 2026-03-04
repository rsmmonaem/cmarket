<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">All Products</h1>
        <p class="text-gray-600 mt-2">Discover amazing products with cashback rewards</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Filters</h3>
                
                <form action="<?php echo e(route('products.index')); ?>" method="GET">
                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Category</h4>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Price Range</h4>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" placeholder="Min" value="<?php echo e(request('min_price')); ?>"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg">
                            <input type="number" name="max_price" placeholder="Max" value="<?php echo e(request('max_price')); ?>"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Sort By</h4>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Latest</option>
                            <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                            <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <a href="<?php echo e(route('products.show', $product)); ?>">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" 
                                     class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl">📦</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-4">
                                <span class="text-xs text-gray-500"><?php echo e($product->category->name); ?></span>
                                <h3 class="font-semibold text-lg mb-2 truncate"><?php echo e($product->name); ?></h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?php echo e($product->description); ?></p>
                                
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <?php if($product->discount_price): ?>
                                            <span class="text-xl font-bold text-indigo-600">৳<?php echo e(number_format($product->discount_price, 2)); ?></span>
                                            <span class="text-sm text-gray-500 line-through ml-2">৳<?php echo e(number_format($product->price, 2)); ?></span>
                                        <?php else: ?>
                                            <span class="text-xl font-bold text-indigo-600">৳<?php echo e(number_format($product->price, 2)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($product->cashback_percentage): ?>
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                            <?php echo e($product->cashback_percentage); ?>% Cashback
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span>Stock: <?php echo e($product->stock); ?></span>
                                    <span><?php echo e($product->merchant->business_name); ?></span>
                                </div>
                                
                                <button onclick="addToCart(<?php echo e($product->id); ?>)" 
                                        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-3 text-center py-12 text-gray-500">
                        No products found
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($products->links()); ?>

            </div>
        </div>
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
            alert('Product added to cart!');
            location.reload();
        } else {
            alert(data.message || 'Failed to add product to cart');
        }
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/products/index.blade.php ENDPATH**/ ?>