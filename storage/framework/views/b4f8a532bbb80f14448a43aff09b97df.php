<?php $__env->startSection('content'); ?>
<!-- Premium Hero Section -->
<div class="relative overflow-hidden bg-indigo-900 text-white py-24 sm:py-32">
    <div class="absolute inset-0 -z-10">
        <svg class="absolute left-[50%] top-0 h-[64rem] w-[128rem] -translate-x-[50%] [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
            <defs>
                <pattern id="e813992c-7d03-4cc4-a2bd-27d760b49999" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M100 200V.5M.5 .5H200" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-27d760b49999)" />
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col items-center text-center">
        <div class="inline-flex items-center space-x-2 bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/20 text-indigo-200 text-sm font-medium mb-6">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
            </span>
            <span>Next-Gen E-commerce Ecosystem</span>
        </div>
        
        <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight mb-6 bg-clip-text text-transparent bg-gradient-to-r from-white via-indigo-200 to-indigo-400">
            Welcome to CMarket
        </h1>
        <p class="text-lg lg:text-xl text-indigo-100 max-w-3xl mb-10 leading-relaxed">
            Shop premium products, earn automated cashback rewards, and build your digital empire through our multi-layer affiliate network.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo e(route('products.index')); ?>" class="w-full sm:w-auto px-10 py-4 bg-white text-indigo-900 rounded-2xl font-bold hover:bg-indigo-50 transition transform hover:scale-105 shadow-2xl shadow-white/10">
                Explore Marketplace
            </a>
            <a href="<?php echo e(route('register')); ?>" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition transform hover:scale-105 shadow-2xl shadow-indigo-500/20">
                Join Ecosystem
            </a>
        </div>
        
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-indigo-300 font-medium">
            <div class="flex flex-col items-center">
                <span class="text-2xl font-bold text-white">50K+</span>
                <span>Active Users</span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-2xl font-bold text-white">200+</span>
                <span>Merchants</span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-2xl font-bold text-white">৳1.5M+</span>
                <span>Cashback Paid</span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-2xl font-bold text-white">24/7</span>
                <span>Support</span>
            </div>
        </div>
    </div>
</div>

<!-- Featured Packages Section (MLM/Self-Logic) -->
<?php if(count($featuredPackages) > 0): ?>
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-24">
    <div class="bg-indigo-50 rounded-[3rem] p-12 lg:p-16 relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-2 block">Special Access</span>
                    <h2 class="text-3xl lg:text-5xl font-extrabold text-gray-900 leading-tight">Exclusive Business Packages</h2>
                </div>
                <a href="<?php echo e(route('products.index', ['type' => 'package'])); ?>" class="text-indigo-600 font-bold hover:text-indigo-800 border-b-2 border-indigo-200 py-1 transition">
                    Browse All Packages →
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php $__currentLoopData = $featuredPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-indigo-900/5 hover:shadow-indigo-900/10 transition-all group border border-transparent hover:border-indigo-100">
                        <div class="aspect-square rounded-2xl bg-indigo-50 mb-6 overflow-hidden relative">
                             <?php $imgArr = is_array($package->images) ? $package->images : (json_decode($package->images, true) ?: []); $img = $imgArr[0] ?? null; ?>
                            <?php if($img): ?>
                                <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="<?php echo e($package->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-5xl">💎</div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                <span class="text-white text-xs font-bold bg-indigo-600 px-3 py-1 rounded-full">ACTIVE PACKAGE</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($package->name); ?></h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-2"><?php echo e($package->description); ?></p>
                        
                        <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-100">
                            <span class="text-2xl font-black text-indigo-900">৳<?php echo e(number_format($package->price, 2)); ?></span>
                            <?php if($package->cashback_percentage): ?>
                                <div class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2 py-1 rounded-lg uppercase tracking-wider">
                                    +<?php echo e($package->cashback_percentage); ?>% CB
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <button onclick="addToCart(<?php echo e($package->id); ?>)" class="w-full mt-6 bg-indigo-900 text-white font-bold py-4 rounded-2xl hover:bg-black transition-colors shadow-lg">
                            Get This Package
                        </button>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/3 w-96 h-96 bg-indigo-200/50 rounded-full blur-3xl"></div>
    </div>
</div>
<?php endif; ?>

<!-- Categories Section -->
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-24">
    <div class="text-center mb-16">
        <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">Discover Categories</h2>
        <p class="text-gray-500">Browse our vast collection of products curated for you</p>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('products.index', ['category' => $category->id])); ?>" class="group">
                <div class="bg-gray-50 rounded-[2.5rem] p-8 text-center border-2 border-transparent group-hover:border-indigo-600 group-hover:bg-white transition-all duration-300">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full overflow-hidden bg-white shadow-xl shadow-gray-200 group-hover:shadow-indigo-100 transition duration-300 flex items-center justify-center">
                        <?php if($category->image): ?>
                            <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="text-3xl transition duration-300 group-hover:scale-125">📦</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition"><?php echo e($category->name); ?></h3>
                    <span class="text-xs font-medium text-gray-400 mt-1 block tracking-wider"><?php echo e($category->products_count ?? 0); ?> ITEMS</span>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Featured Marketplace Products -->
<div class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900">Trending Now</h2>
                <p class="text-gray-500 mt-2">Check out what's hot in the marketplace</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="px-6 py-2 bg-white rounded-xl font-bold text-gray-900 border border-gray-200 hover:border-indigo-600 transition shadow-sm">
                View All
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-[2rem] overflow-hidden group hover:shadow-2xl hover:shadow-indigo-900/5 transition duration-500">
                    <a href="<?php echo e(route('products.show', $product)); ?>" class="block p-4">
                        <div class="aspect-[4/5] rounded-2xl bg-gray-100 overflow-hidden relative">
                             <?php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; ?>
                            <?php if($img): ?>
                                <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-6xl">🛍️</div>
                            <?php endif; ?>
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm text-gray-900 text-[10px] font-black px-3 py-1 rounded-full shadow-sm tracking-widest uppercase">
                                    <?php echo e($product->category->name ?? 'GENERAL'); ?>

                                </span>
                            </div>
                        </div>
                        
                        <div class="pt-6 px-2">
                            <h3 class="font-bold text-gray-900 text-lg mb-1 truncate"><?php echo e($product->name); ?></h3>
                            <div class="flex items-baseline gap-2 mb-4">
                                <?php if($product->discount_price): ?>
                                    <span class="text-2xl font-black text-indigo-600">৳<?php echo e(number_format($product->discount_price, 2)); ?></span>
                                    <span class="text-sm text-gray-400 line-through">৳<?php echo e(number_format($product->price, 2)); ?></span>
                                <?php else: ?>
                                    <span class="text-2xl font-black text-indigo-900">৳<?php echo e(number_format($product->price, 2)); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex items-center justify-between gap-4">
                                <button onclick="addToCart(<?php echo e($product->id); ?>)" class="flex-1 bg-gray-900 text-white font-bold py-3 rounded-2xl hover:bg-indigo-600 transition shadow-lg shadow-gray-200">
                                    Quick Add
                                </button>
                                <button class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-2xl hover:bg-red-50 hover:text-red-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>

<style>
.gradient-bg {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/welcome.blade.php ENDPATH**/ ?>