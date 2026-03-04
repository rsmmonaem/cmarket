<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['route', 'icon', 'label']));

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

foreach (array_filter((['route', 'icon', 'label']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $isActive = request()->routeIs($route) || (strpos($route, '.') !== false && request()->routeIs(explode('.', $route)[0] . '.*'));
?>

<a href="<?php echo e(route($route)); ?>" 
   class="sidebar-link <?php echo e($isActive ? 'active' : ''); ?>">
    <span class="text-lg opacity-80"><?php echo e($icon); ?></span>
    <span class="font-bold text-sm"><?php echo e($label); ?></span>
</a>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/components/admin/sidebar-link.blade.php ENDPATH**/ ?>