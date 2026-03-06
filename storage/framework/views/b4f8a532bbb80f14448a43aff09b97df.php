<?php $__env->startSection('content'); ?>
<div class="space-y-20 pb-20">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Categories (Desktop) -->
            <div class="hidden lg:block bg-white rounded-3xl border border-slate-100 shadow-sm p-4 h-full">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 px-4">Popular Spheres</p>
                <div class="space-y-1">
                    <?php $__currentLoopData = $popularCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('categories.index')); ?>" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors group">
                            <span class="text-sm font-bold text-slate-700 group-hover:text-primary transition-colors"><?php echo e($cat->name); ?></span>
                            <span class="text-[9px] font-black text-slate-300 group-hover:text-primary opacity-0 group-hover:opacity-100 transition-all">➔</span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Hero Banner Slider -->
            <div class="lg:col-span-3">
                <div class="relative rounded-4xl overflow-hidden aspect-[21/9] lg:aspect-auto lg:h-[480px] gradient-orange group">
                    <?php $__empty_1 = true; $__currentLoopData = $mainBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="absolute inset-0 transition-opacity duration-1000">
                            <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex flex-col justify-center px-8 md:px-20 text-white">
                                <h1 class="text-3xl md:text-6xl font-black mb-4 leading-tight tracking-tighter"><?php echo e($banner->title); ?></h1>
                                <a href="<?php echo e($banner->link ?? '#'); ?>" class="inline-flex items-center gap-4 bg-white text-primary px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 transition-transform shadow-2xl">
                                    Shop Now node ➔
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="absolute inset-0 flex flex-col justify-center px-12 md:px-20 text-white">
                            <h1 class="text-4xl md:text-7xl font-black mb-6 leading-tight tracking-tighter">Best Finds – <br><span class="text-white/80">30% OFF</span></h1>
                            <a href="#" class="inline-flex items-center gap-4 bg-white text-primary px-10 py-5 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:scale-105 transition-transform shadow-2xl w-fit">
                                Start Discovery ➔
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Deals Section -->
    <?php if($flashDeals->count() > 0): ?>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[3rem] p-8 md:p-12 border border-orange-100 shadow-xl shadow-orange-500/5 relative overflow-hidden">
            <!-- Decor -->
            <div class="absolute top-0 right-0 p-12 opacity-[0.03] pointer-events-none">
                <span class="text-9xl font-black italic">FLASH</span>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-12 relative z-10">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-primary text-white flex items-center justify-center text-3xl rounded-3xl shadow-lg shadow-orange-500/20">
                        ⚡
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Flash Deals Matrix</h2>
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mt-1">Limited temporal availability node</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest hidden md:block">Ending In:</p>
                    <div class="flex gap-2 font-black text-slate-800">
                        <span id="cd-hours" class="bg-slate-100 px-4 py-2 rounded-xl text-lg">00</span>
                        <span class="text-slate-300 text-lg">:</span>
                        <span id="cd-minutes" class="bg-slate-100 px-4 py-2 rounded-xl text-lg">00</span>
                        <span class="text-slate-300 text-lg">:</span>
                        <span id="cd-seconds" class="bg-slate-100 px-4 py-2 rounded-xl text-lg">00</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 relative z-10">
                <?php $__currentLoopData = $flashDeals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group bg-slate-50 rounded-[2rem] p-4 hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 relative">
                        <!-- Discount Badge -->
                        <?php if($product->discount_percentage > 0): ?>
                            <div class="absolute top-6 left-6 z-10 bg-rose-500 text-white text-[9px] font-black px-3 py-1.5 rounded-lg shadow-lg">
                                -<?php echo e(round($product->discount_percentage)); ?>%
                            </div>
                        <?php endif; ?>
                        
                        <div class="aspect-square rounded-2xl bg-white overflow-hidden mb-6 flex items-center justify-center border border-slate-100 group-hover:scale-95 transition-transform">
                            <?php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; ?>
                            <?php if($img): ?>
                                <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-4xl opacity-10">🛍️</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="space-y-3">
                            <p class="text-[9px] font-black text-primary uppercase tracking-widest"><?php echo e($product->category->name ?? 'Product'); ?></p>
                            <h3 class="text-sm font-black text-slate-800 line-clamp-1 h-5"><?php echo e($product->name); ?></h3>
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg font-black text-slate-900">৳<?php echo e(number_format($product->final_price)); ?></span>
                                <?php if($product->discount_price): ?>
                                    <span class="text-[10px] font-bold text-slate-400 line-through">৳<?php echo e(number_format($product->price)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick Add -->
                        <div class="mt-6 flex gap-2">
                            <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST" class="flex-1">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-primary transition-all active:scale-95">
                                    Capture Node
                                </button>
                            </form>
                            <button class="w-12 bg-white border border-slate-100 rounded-xl flex items-center justify-center hover:text-primary transition-colors">
                                🤍
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Popular Categories -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Taxonomy Nodes</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Explore the marketplace architecture</p>
            </div>
            <a href="<?php echo e(route('categories.index')); ?>" class="text-[10px] font-black text-primary uppercase tracking-widest hover:brightness-110">View Global Map ➔</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <?php $__currentLoopData = $popularCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('categories.index')); ?>" class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-soft hover:shadow-2xl hover:shadow-slate-200/50 hover:-translate-y-2 transition-all text-center flex flex-col items-center">
                    <div class="w-20 h-20 rounded-3xl bg-slate-50 flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition-transform overflow-hidden font-black">
                        <?php if($cat->image): ?>
                            <img src="<?php echo e(asset('storage/' . $cat->image)); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            📂
                        <?php endif; ?>
                    </div>
                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest group-hover:text-primary transition-colors"><?php echo e($cat->name); ?></span>
                    <span class="text-[9px] font-bold text-slate-400 mt-2"><?php echo e($cat->products_count); ?> Nodes</span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- Mid Promotional Banners -->
    <?php if($midBanners->count() > 0): ?>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php $__currentLoopData = $midBanners->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative rounded-[3rem] overflow-hidden group aspect-[16/7]">
                    <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-10 text-white">
                        <h3 class="text-2xl font-black mb-4 tracking-tight"><?php echo e($banner->title); ?></h3>
                        <a href="<?php echo e($banner->link ?? '#'); ?>" class="text-[10px] font-black uppercase tracking-widest border-b-2 border-primary pb-1 w-fit">Initiate Discovery Node ➔</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Featured Products Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Critical Nodes</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Highly optimized marketplace featured assets</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="text-[10px] font-black text-primary uppercase tracking-widest">Execute Full Scan ➔</a>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4 md:gap-6">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group bg-white rounded-[2rem] p-5 border border-slate-100 shadow-soft hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 relative flex flex-col h-full">
                    <div class="aspect-square rounded-2xl bg-slate-50 overflow-hidden mb-6 flex items-center justify-center group-hover:scale-95 transition-transform overflow-hidden relative">
                        <?php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; ?>
                        <?php if($img): ?>
                            <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="text-3xl opacity-10">🛍️</span>
                        <?php endif; ?>
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-primary/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="flex gap-4">
                                <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-12 h-12 bg-white rounded-xl shadow-xl flex items-center justify-center hover:scale-110 transition-transform">🛒</button>
                                </form>
                                <a href="<?php echo e(route('products.show', $product)); ?>" class="w-12 h-12 bg-white rounded-xl shadow-xl flex items-center justify-center hover:scale-110 transition-transform">👁️</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3 flex-1">
                        <div class="flex justify-between items-start">
                             <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($product->category->name ?? 'Node'); ?></p>
                             <div class="flex text-[8px] text-amber-400">★★★★☆</div>
                        </div>
                        <h3 class="text-xs font-black text-slate-700 line-clamp-2 h-8 leading-relaxed"><?php echo e($product->name); ?></h3>
                        <div class="pt-2 flex items-baseline gap-2">
                            <span class="text-sm font-black text-slate-900 uppercase">৳<?php echo e(number_format($product->final_price)); ?></span>
                            <?php if($product->discount_price): ?>
                                <span class="text-[8px] font-bold text-slate-300 line-through">৳<?php echo e(number_format($product->price)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- Top Merchants Section -->
    <section class="bg-slate-900 py-32 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute inset-0 opacity-10 pointer-events-none grid grid-cols-4 gap-4 p-20 rotate-12">
            <?php for($i=0; $i<16; $i++): ?>
                <div class="aspect-square bg-slate-800 rounded-3xl"></div>
            <?php endfor; ?>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-16 text-center lg:text-left">
                <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight">Merchant Infrastructure</h2>
                <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mt-3">Verified multi-merchant source nodes</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $topMerchants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $merchant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-slate-800/50 backdrop-blur-md p-8 rounded-[3rem] border border-slate-700/50 flex items-center gap-8 group hover:bg-slate-800 transition-colors">
                        <div class="w-24 h-24 rounded-4xl bg-white p-4 flex items-center justify-center group-hover:scale-110 transition-transform shadow-2xl">
                            <?php if($merchant->logo): ?>
                                <img src="<?php echo e(asset('storage/' . $merchant->logo)); ?>" class="w-full h-full object-contain">
                            <?php else: ?>
                                <span class="text-4xl">🏢</span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white mb-2"><?php echo e($merchant->shop_name ?? $merchant->business_name); ?></h3>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4"><?php echo e($merchant->products_count); ?> ACTIVE NODES</p>
                            <a href="<?php echo e(route('products.index', ['merchant' => $merchant->id])); ?>" class="inline-flex h-10 px-6 bg-primary text-white items-center justify-center rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-primary-hover transition-colors shadow-lg shadow-orange-500/10">
                                Visit Store node
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-center">
            <div class="space-y-6 group">
                <div class="w-20 h-20 bg-slate-100 rounded-[2rem] mx-auto flex items-center justify-center text-3xl group-hover:bg-primary group-hover:text-white transition-all shadow-soft group-hover:shadow-orange-500/20 group-hover:-translate-y-2">🚀</div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-3">Fast Delivery Hub</h4>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed">Logistical optimization for sub-24h node synchronization.</p>
                </div>
            </div>
            <div class="space-y-6 group">
                <div class="w-20 h-20 bg-slate-100 rounded-[2rem] mx-auto flex items-center justify-center text-3xl group-hover:bg-primary group-hover:text-white transition-all shadow-soft group-hover:shadow-orange-500/20 group-hover:-translate-y-2">🛡️</div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-3">Safe Payment Matrix</h4>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed">End-to-end encrypted financial transaction nodes.</p>
                </div>
            </div>
            <div class="space-y-6 group">
                <div class="w-20 h-20 bg-slate-100 rounded-[2rem] mx-auto flex items-center justify-center text-3xl group-hover:bg-primary group-hover:text-white transition-all shadow-soft group-hover:shadow-orange-500/20 group-hover:-translate-y-2">🔄</div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-3">7 Day Return Protocol</h4>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed">Seamless asset rollback for verified user comfort.</p>
                </div>
            </div>
            <div class="space-y-6 group">
                <div class="w-20 h-20 bg-slate-100 rounded-[2rem] mx-auto flex items-center justify-center text-3xl group-hover:bg-primary group-hover:text-white transition-all shadow-soft group-hover:shadow-orange-500/20 group-hover:-translate-y-2">✅</div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-3">100% Authentic Nodes</h4>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed">Verified manufacturer origin for every marketplace asset.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if($popupBanner): ?>
<!-- Initial Popup Matrix -->
<div id="matrix-popup" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-md opacity-0 invisible transition-all duration-700">
    <div class="bg-white rounded-[3rem] overflow-hidden max-w-lg w-full relative shadow-2xl scale-90 transition-transform duration-700" id="popup-content">
        <button onclick="closePopup()" class="absolute top-6 right-6 w-10 h-10 bg-black/10 hover:bg-black/20 rounded-xl flex items-center justify-center text-xl font-bold transition-colors">✕</button>
        <img src="<?php echo e(asset('storage/' . $popupBanner->image)); ?>" class="w-full aspect-square object-cover">
        <div class="p-10 text-center">
            <h3 class="text-2xl font-black mb-4 tracking-tight"><?php echo e($popupBanner->title); ?></h3>
            <a href="<?php echo e($popupBanner->link ?? '#'); ?>" class="inline-flex bg-primary text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-xl shadow-orange-500/20">Explore Node ➔</a>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        setTimeout(() => {
            const popup = document.getElementById('matrix-popup');
            const content = document.getElementById('popup-content');
            popup.classList.remove('opacity-0', 'invisible');
            content.classList.remove('scale-90');
        }, 3000);
    };

    function closePopup() {
        const popup = document.getElementById('matrix-popup');
        popup.classList.add('opacity-0', 'invisible');
    }
</script>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function updateCountdown() {
        const dealEnd = new Date("<?php echo e($flashDeals->first()?->flash_deal_end ?? now()->addDays(1)); ?>").getTime();
        const now = new Date().getTime();
        const distance = dealEnd - now;

        if (distance < 0) return;

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('cd-hours').innerText = hours.toString().padStart(2, '0');
        document.getElementById('cd-minutes').innerText = minutes.toString().padStart(2, '0');
        document.getElementById('cd-seconds').innerText = seconds.toString().padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/welcome.blade.php ENDPATH**/ ?>