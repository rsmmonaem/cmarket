<?php $__env->startSection('title', 'Marketplace'); ?>
<?php $__env->startSection('page-title', 'Marketplace'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; flex-direction: column; md-flex-direction: row; gap: 2rem;">
    <!-- Filters Sidebar -->
    <aside style="width: 100%; md-width: 280px; flex-shrink: 0;">
        <div class="card-solid">
            <h3 style="margin-bottom: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                <span>🔍</span> Filters
            </h3>
            
            <form action="<?php echo e(route('products.index')); ?>" method="GET">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.75rem;">Category</label>
                    <select name="category" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.75rem;">Price Range</label>
                    <div style="display: flex; gap: 0.75rem;">
                        <input type="number" name="min_price" placeholder="Min" value="<?php echo e(request('min_price')); ?>" style="width: 50%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                        <input type="number" name="max_price" placeholder="Max" value="<?php echo e(request('max_price')); ?>" style="width: 50%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.75rem;">Sort By</label>
                    <select name="sort" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                        <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Newest Arrivals</option>
                        <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                        <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Alphabetical</option>
                    </select>
                </div>

                <button type="submit" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center;">
                    Refine Results ✨
                </button>
            </form>
        </div>
    </aside>

    <!-- Products Grid -->
    <div style="flex: 1;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card-solid" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
                    <a href="<?php echo e(route('products.show', $product)); ?>" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                        <div style="height: 200px; position: relative; background: #f1f5f9;">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                            <?php endif; ?>
                            
                            <?php if($product->cashback_percentage): ?>
                                <div style="position: absolute; top: 1rem; right: 1rem; background: var(--success); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <?php echo e($product->cashback_percentage); ?>% CASHBACK
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                            <div style="font-size: 0.75rem; color: var(--text-muted-light); font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;"><?php echo e($product->category->name); ?></div>
                            <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.75rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;"><?php echo e($product->name); ?></h3>
                            
                            <div style="margin-top: auto;">
                                <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 1rem;">
                                    <?php if($product->discount_price): ?>
                                        <span style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">৳<?php echo e(number_format($product->discount_price, 2)); ?></span>
                                        <span style="font-size: 0.875rem; color: var(--text-muted-light); text-decoration: line-through;">৳<?php echo e(number_format($product->price, 2)); ?></span>
                                    <?php else: ?>
                                        <span style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">৳<?php echo e(number_format($product->price, 2)); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: var(--text-muted-light); margin-bottom: 1.5rem;">
                                    <span>Stock: <strong style="color: <?php echo e($product->stock > 0 ? 'var(--success)' : 'var(--danger)'); ?>"><?php echo e($product->stock); ?></strong></span>
                                    <span>Merchant: <strong><?php echo e($product->merchant->business_name); ?></strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div style="padding: 0 1.5rem 1.5rem 1.5rem; margin-top: auto;">
                        <button onclick="addToCart(<?php echo e($product->id); ?>)" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center; padding: 0.875rem;">
                            <span>🛒</span> Add to Cart
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem;">
                    <div style="font-size: 4rem; margin-bottom: 1.5rem;">🔍</div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">No products matched your criteria</h3>
                    <p style="color: var(--text-muted-light); margin-top: 0.5rem;">Try adjusting your filters or search terms.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 3rem;">
            <?php echo e($products->links()); ?>

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
            alert('Added to your cart! 🛍️');
            location.reload();
        } else {
            alert(data.message || 'Error occurred while adding to cart.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Could not add to cart. Please try again.');
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/products/index.blade.php ENDPATH**/ ?>