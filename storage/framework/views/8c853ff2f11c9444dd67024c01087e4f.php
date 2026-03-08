<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - C-Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-custom.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark', 'dark-mode');
        } else {
            document.documentElement.classList.remove('dark', 'dark-mode');
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#f8fafc] dark:bg-[#0f172a] text-[#1e293b] dark:text-[#f1f5f9] font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">
    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" 
         @click="sidebarOpen = false"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-[260px] bg-[#1e293b] text-slate-400 fixed inset-y-0 left-0 z-50 transform lg:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-800 shadow-xl overflow-y-auto sidebar-scroll"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header / Logo -->
            <div class="h-[64px] flex items-center px-6 border-b border-slate-800/50 bg-[#1e293b] sticky top-0 z-10">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold">
                        C
                    </div>
                    <span class="text-lg font-bold text-slate-100 tracking-tight">C-Market <span class="text-primary/80 font-medium">Pro</span></span>
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="py-4 pb-24">
                <div class="px-6 mb-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500/80">Analytical</p>
                </div>
                <div class="space-y-0.5 mb-6">
                    <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.dashboard','icon' => '📊','label' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.dashboard','icon' => '📊','label' => 'Dashboard']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                </div>

                <div class="px-6 mb-4 mt-6">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500/80">Operations</p>
                </div>
                <div class="space-y-0.5 mb-6">
                    <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.merchants.index','icon' => '🏢','label' => 'Merchants']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.merchants.index','icon' => '🏢','label' => 'Merchants']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.pos.index','icon' => '🖥️','label' => 'POS Terminal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.pos.index','icon' => '🖥️','label' => 'POS Terminal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.commissions.index','icon' => '🤝','label' => 'Affiliates']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.commissions.index','icon' => '🤝','label' => 'Affiliates']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.products.index','icon' => '📁','label' => 'Procurement']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.products.index','icon' => '📁','label' => 'Procurement']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                </div>

                <div class="px-6 mb-4 mt-6">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500/80">Sales & Logs</p>
                </div>
                <div class="space-y-0.5 mb-6">
                    <?php if (isset($component)) { $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-dropdown','data' => ['icon' => '🛍️','label' => 'Order Pipeline','active' => request()->is('admin/orders*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '🛍️','label' => 'Order Pipeline','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->is('admin/orders*'))]); ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.orders.index','label' => 'Overview']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.orders.index','label' => 'Overview']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.orders.index','params' => ['status' => 'pending'],'label' => 'Pending']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.orders.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['status' => 'pending']),'label' => 'Pending']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.orders.index','params' => ['status' => 'confirmed'],'label' => 'Confirmed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.orders.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['status' => 'confirmed']),'label' => 'Confirmed']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.orders.index','params' => ['status' => 'packaging'],'label' => 'Infrastructure']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.orders.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['status' => 'packaging']),'label' => 'Infrastructure']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.orders.index','params' => ['status' => 'delivered'],'label' => 'Completed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.orders.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['status' => 'delivered']),'label' => 'Completed']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $attributes = $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $component = $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-dropdown','data' => ['icon' => '💸','label' => 'Refunds','active' => request()->is('admin/refunds*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '💸','label' => 'Refunds','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->is('admin/refunds*'))]); ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.refunds.index','label' => 'Requests']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.refunds.index','label' => 'Requests']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.refunds.index','label' => 'Settlements']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.refunds.index','label' => 'Settlements']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $attributes = $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $component = $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
                </div>

                <div class="px-6 mb-4 mt-6">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500/80">Asset Catalog</p>
                </div>
                <div class="space-y-0.5 mb-6">
                    <?php if (isset($component)) { $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-dropdown','data' => ['icon' => '📦','label' => 'Products','active' => request()->routeIs('admin.products.*', 'admin.categories.*', 'admin.sub-categories.*', 'admin.sub-sub-categories.*', 'admin.brands.*', 'admin.attributes.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '📦','label' => 'Products','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.products.*', 'admin.categories.*', 'admin.sub-categories.*', 'admin.sub-sub-categories.*', 'admin.brands.*', 'admin.attributes.*'))]); ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.categories.index','label' => 'Hierarchy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.categories.index','label' => 'Hierarchy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.sub-categories.index','label' => 'Sub-Categories']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.sub-categories.index','label' => 'Sub-Categories']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.brands.index','label' => 'Brand Registry']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.brands.index','label' => 'Brand Registry']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.attributes.index','label' => 'Specifications']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.attributes.index','label' => 'Specifications']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.products.index','label' => 'In-house Stocks']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.products.index','label' => 'In-house Stocks']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.products.index','params' => ['type' => 'merchant'],'label' => 'Merchant Assets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.products.index','params' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['type' => 'merchant']),'label' => 'Merchant Assets']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $attributes = $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $component = $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
                </div>

                <div class="px-6 mb-4 mt-6">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500/80">Ecosystem</p>
                </div>
                <div class="space-y-0.5 mb-6">
                    <?php if (isset($component)) { $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-dropdown','data' => ['icon' => '👥','label' => 'Stakeholders','active' => request()->routeIs('admin.users.*', 'admin.merchants.*', 'admin.riders.*', 'admin.kyc.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '👥','label' => 'Stakeholders','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.users.*', 'admin.merchants.*', 'admin.riders.*', 'admin.kyc.*'))]); ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.users.index','label' => 'Consumer Base']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.users.index','label' => 'Consumer Base']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.merchants.index','label' => 'Merchant Network']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.merchants.index','label' => 'Merchant Network']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.riders.index','label' => 'Delivery Fleet']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.riders.index','label' => 'Delivery Fleet']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.kyc.index','label' => 'Verifications']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.kyc.index','label' => 'Verifications']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $attributes = $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $component = $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-dropdown','data' => ['icon' => '⚡','label' => 'Marketing','active' => request()->routeIs('admin.banners.*', 'admin.coupons.*', 'admin.flash-deals.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '⚡','label' => 'Marketing','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.banners.*', 'admin.coupons.*', 'admin.flash-deals.*'))]); ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.banners.index','label' => 'Banners']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.banners.index','label' => 'Banners']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.coupons.index','label' => 'Vouchers']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.coupons.index','label' => 'Vouchers']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.flash-deals.index','label' => 'Campaigns']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.flash-deals.index','label' => 'Campaigns']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $attributes = $__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__attributesOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b)): ?>
<?php $component = $__componentOriginal1ec1143df31c70ac0673c8a3095ec97b; ?>
<?php unset($__componentOriginal1ec1143df31c70ac0673c8a3095ec97b); ?>
<?php endif; ?>
                </div>

                <div class="px-6 mb-4 mt-6">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500/80">Management</p>
                </div>
                <div class="space-y-0.5 mb-6">
                    <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.settings.index','icon' => '⚙️','label' => 'System Config']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.settings.index','icon' => '⚙️','label' => 'System Config']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal25b36b426f30fd196f9d947e60e48c56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b36b426f30fd196f9d947e60e48c56 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar-link','data' => ['route' => 'admin.dashboard','icon' => '📈','label' => 'Financial Audits']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.dashboard','icon' => '📈','label' => 'Financial Audits']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $attributes = $__attributesOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__attributesOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b36b426f30fd196f9d947e60e48c56)): ?>
<?php $component = $__componentOriginal25b36b426f30fd196f9d947e60e48c56; ?>
<?php unset($__componentOriginal25b36b426f30fd196f9d947e60e48c56); ?>
<?php endif; ?>
                </div>
            </nav>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 lg:ml-[260px] min-h-screen transition-all duration-300">
            <!-- Header -->
            <header class="h-[70px] bg-white dark:bg-[#0f172a] border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 md:px-8 sticky top-0 z-40 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="hidden md:flex items-center bg-slate-100 dark:bg-slate-800 rounded-2xl px-4 py-2 w-[400px] border border-transparent focus-within:border-primary/20 focus-within:bg-white dark:focus-within:bg-[#1e293b] transition-all group">
                        <span class="text-slate-400 group-focus-within:text-primary transition-colors">🔍</span>
                        <input type="text" placeholder="Global asset search..." class="bg-transparent border-none focus:ring-0 text-sm w-full ml-3 font-medium placeholder:text-slate-400 text-slate-600 dark:text-slate-200">
                    </div>
                </div>

                <div class="flex items-center gap-2 md:gap-5">
                    <!-- Language Loader -->
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 cursor-pointer hover:bg-white dark:hover:bg-slate-700 transition-all">
                        <span class="text-xs font-black text-slate-500 uppercase">EN</span>
                        <span class="text-[10px] text-slate-300">|</span>
                        <span class="text-xs font-black text-primary uppercase">BN</span>
                    </div>

                    <!-- Notifications -->
                    <button class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-primary hover:bg-white dark:hover:bg-slate-700 border border-slate-100 dark:border-slate-700 transition-all relative">
                        <span>🔔</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800"></span>
                    </button>

                    <!-- Messages -->
                    <button class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-accent hover:bg-white dark:hover:bg-slate-700 border border-slate-100 dark:border-slate-700 transition-all relative">
                        <span>💬</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-sky-500 rounded-full border-2 border-white dark:border-slate-800"></span>
                    </button>

                    <div class="h-6 w-px bg-slate-200 dark:bg-slate-800 mx-1 hidden sm:block"></div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1.5 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                            <div class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-black shadow-lg shadow-primary/20 uppercase">
                                <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                            </div>
                            <div class="text-left hidden sm:block">
                                <div class="text-[11px] font-black text-slate-800 dark:text-white leading-none uppercase"><?php echo e(Auth::user()->name); ?></div>
                                <div class="text-[8px] font-black text-slate-400 uppercase mt-0.5 tracking-tighter">Administrator</div>
                            </div>
                            <span class="text-[10px] text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">▼</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-[#1e293b] rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 p-2 z-[60]">
                            <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-800 mb-2">
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Signed in as</p>
                                <p class="text-xs font-black text-slate-800 dark:text-white truncate"><?php echo e(Auth::user()->email); ?></p>
                            </div>
                            <a href="<?php echo e(route('admin.users.edit', Auth::user())); ?>" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-all rounded-xl">
                                👤 My Profile
                            </a>
                            <a href="<?php echo e(route('admin.settings.index')); ?>" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-all rounded-xl">
                                ⚙️ System Settings
                            </a>
                            <div class="border-t border-slate-50 dark:border-slate-800 my-2"></div>
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-xs font-black text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all rounded-xl">
                                    🚪 Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content Inner -->
            <div class="p-6 lg:p-10 max-w-[1600px] mx-auto">
                
                <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-6">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-primary transition-colors">Admin Hub</a>
                    <span>/</span>
                    <span class="text-slate-800 dark:text-slate-200"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></span>
                </div>

                <?php echo $__env->yieldContent('content'); ?>
            </div>

            <!-- Footer -->
            <footer class="p-6 lg:px-10 mt-auto border-t border-slate-200 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4 text-slate-400 text-[11px] font-medium tracking-wide">
                <div>
                    &copy; <?php echo e(date('Y')); ?> <span class="text-slate-600 dark:text-slate-500 font-semibold">C-Market Pro.</span> Platform Management
                </div>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-primary transition-colors">Reference</a>
                    <a href="#" class="hover:text-primary transition-colors">Support</a>
                    <a href="#" class="hover:text-primary transition-colors">v2.4.0</a>
                </div>
            </footer>
        </main>
    </div>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        // Simple theme logic if needed for sidebar specifically, 
        // but the head script handles initial load.

        // SweetAlert Notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        <?php if(session('success')): ?>
            Toast.fire({ icon: 'success', title: "<?php echo e(session('success')); ?>" });
        <?php endif; ?>
        <?php if(session('error')): ?>
            Toast.fire({ icon: 'error', title: "<?php echo e(session('error')); ?>" });
        <?php endif; ?>
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/layouts/admin.blade.php ENDPATH**/ ?>