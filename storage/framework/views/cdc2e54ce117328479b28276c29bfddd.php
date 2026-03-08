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
        $isActive = request()->url() === $generatedUrl && empty(request()->query());
    }
?>

<a href="<?php echo e($generatedUrl); ?>" 
   class="flex items-center gap-3 px-6 py-2.5 transition-all duration-200 group <?php echo e($isActive ? 'text-white bg-slate-800/50 border-r-4 border-primary' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/30'); ?>">
    <?php if(isset($icon)): ?>
        <span class="text-lg opacity-70 group-hover:opacity-100 transition-opacity"><?php echo e($icon); ?></span>
    <?php endif; ?>
    <span class="text-[13px] font-semibold tracking-tight"><?php echo e($label); ?></span>
</a>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/components/admin/sidebar-link.blade.php ENDPATH**/ ?>