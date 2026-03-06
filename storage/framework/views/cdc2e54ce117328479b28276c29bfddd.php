<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['route', 'icon', 'label', 'params' => []]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['route', 'icon', 'label', 'params' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $routeName = is_string($route) ? $route : '#';
    $generatedUrl = $routeName !== '#' ? route($routeName, $params) : '#';
    
    // Exact match for parameters if present, otherwise base URL match
    if (!empty($params)) {
        $isActive = request()->fullUrl() === $generatedUrl;
    } else {
        // If no params, ensure the current full URL doesn't have extra params that shouldn't belong here
        $isActive = request()->url() === $generatedUrl && empty(request()->query());
    }
?>

<a href="<?php echo e($generatedUrl); ?>" 
   class="flex items-center justify-between group px-4 py-3 rounded-xl transition-all duration-300 <?php echo e($isActive ? 'bg-primary text-white shadow-xl shadow-primary/30 active-node' : 'text-slate-400 hover:text-white hover:bg-white/5'); ?>">
    <div class="flex items-center gap-3">
        <?php if(isset($icon)): ?>
            <span class="text-lg opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-transform"><?php echo e($icon); ?></span>
        <?php endif; ?>
        <span class="font-black text-[11px] uppercase tracking-wider"><?php echo e($label); ?></span>
    </div>
    <?php if($isActive): ?>
        <div class="w-1.5 h-1.5 rounded-full bg-white shadow-sm"></div>
    <?php endif; ?>
</a>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/components/admin/sidebar-link.blade.php ENDPATH**/ ?>