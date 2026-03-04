<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Customer Dashboard'); ?> - CMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-custom.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 280px;
            --primary-gradient: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            --active-gradient: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 100%);
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        
        .sidebar {
            width: var(--sidebar-w);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
        }

        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link.active {
            background: var(--active-gradient);
            color: #3b82f6;
            border-left: 4px solid #3b82f6;
        }
        
        .glass-topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</head>
<body class="text-slate-900 overflow-x-hidden">
    <!-- Mobile Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="dashboard-container flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar sidebar-solid fixed left-0 top-0 bottom-0 z-50 overflow-y-auto bg-[#0f172a]">
            <div class="p-6">
                <div class="flex items-center justify-between mb-10">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 no-underline">
                        <span class="w-10 h-10 rounded-xl bg-sky-500 flex items-center justify-center text-xl shadow-lg shadow-sky-500/20">🛒</span>
                        <span class="text-xl font-extrabold text-white tracking-tight">CMARKET</span>
                    </a>
                    <button class="lg:hidden text-white opacity-50 hover:opacity-100" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="space-y-8">
                    <div>
                        <div class="px-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-4">Personal</div>
                        <nav class="space-y-1">
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'customer.dashboard','icon' => '📊','label' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'customer.dashboard','icon' => '📊','label' => 'Dashboard']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'wallet.index','icon' => '💰','label' => 'Wallets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'wallet.index','icon' => '💰','label' => 'Wallets']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'withdrawals.index','icon' => '🏦','label' => 'Withdrawals']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'withdrawals.index','icon' => '🏦','label' => 'Withdrawals']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'orders.index','icon' => '🛍️','label' => 'Orders']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'orders.index','icon' => '🛍️','label' => 'Orders']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'referrals.index','icon' => '🤝','label' => 'Referrals']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'referrals.index','icon' => '🤝','label' => 'Referrals']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'customer.generations','icon' => '🌍','label' => 'Generations']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'customer.generations','icon' => '🌍','label' => 'Generations']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                        </nav>
                    </div>

                    <div>
                        <div class="px-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-4">Earnings</div>
                        <nav class="space-y-1">
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'customer.commissions','icon' => '📈','label' => 'Commissions']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'customer.commissions','icon' => '📈','label' => 'Commissions']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'customer.designation','icon' => '🏆','label' => 'Designations']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'customer.designation','icon' => '🏆','label' => 'Designations']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'kyc.index','icon' => '🆔','label' => 'Verification']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'kyc.index','icon' => '🆔','label' => 'Verification']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                        </nav>
                    </div>

                    <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'upazila|district|division|director')): ?>
                    <div>
                        <div class="px-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-4">Regional</div>
                        <nav class="space-y-1">
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'regional.dashboard','icon' => '🌎','label' => 'Management']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'regional.dashboard','icon' => '🌎','label' => 'Management']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                        </nav>
                    </div>
                    <?php endif; ?>

                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'merchant')): ?>
                    <div>
                        <div class="px-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-4">Business</div>
                        <nav class="space-y-1">
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'merchant.dashboard','icon' => '🏪','label' => 'Shop Hub']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'merchant.dashboard','icon' => '🏪','label' => 'Shop Hub']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'merchant.products.index','icon' => '📦','label' => 'My Products']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'merchant.products.index','icon' => '📦','label' => 'My Products']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'merchant.orders.index','icon' => '🛍️','label' => 'Customer Orders']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'merchant.orders.index','icon' => '🛍️','label' => 'Customer Orders']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'merchant.reports.sales','icon' => '📈','label' => 'Sales Analytics']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'merchant.reports.sales','icon' => '📈','label' => 'Sales Analytics']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                        </nav>
                    </div>
                    <?php endif; ?>

                    <div>
                        <div class="px-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-4">Market</div>
                        <nav class="space-y-1">
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'products.index','icon' => '📦','label' => 'Shop Products']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'products.index','icon' => '📦','label' => 'Shop Products']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'investments.index','icon' => '🏗️','label' => 'Investments']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'investments.index','icon' => '🏗️','label' => 'Investments']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal09b447af36c3b97597f148261cc2691d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09b447af36c3b97597f148261cc2691d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.sidebar-link','data' => ['route' => 'investments.my-shares','icon' => '💎','label' => 'My Portfolio']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'investments.my-shares','icon' => '💎','label' => 'My Portfolio']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $attributes = $__attributesOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__attributesOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09b447af36c3b97597f148261cc2691d)): ?>
<?php $component = $__componentOriginal09b447af36c3b97597f148261cc2691d; ?>
<?php unset($__componentOriginal09b447af36c3b97597f148261cc2691d); ?>
<?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-1 min-h-screen lg:ml-[280px]">
            <!-- Topbar -->
            <header class="glass-topbar sticky top-0 z-30 px-4 py-4 md:px-8 md:py-6 flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <button class="p-2 lg:hidden rounded-xl hover:bg-slate-100 transition" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-slate-800"><?php echo e(Auth::user()->name); ?></div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-sky-500"><?php echo e(Auth::user()->status); ?></div>
                    </div>
                    
                    <div class="relative group">
                        <button class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-lg hover:border-sky-500 hover:shadow-lg hover:shadow-sky-500/10 transition-all duration-300">
                            👤
                        </button>
                        <!-- Dropdown with transparent bridge to maintain hover -->
                        <div class="absolute right-0 top-full pt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <div class="bg-white rounded-[1.5rem] shadow-2xl border border-slate-100 py-4 overflow-hidden">
                                <div class="px-6 py-3 border-b border-slate-50 mb-2">
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?php echo e(Auth::user()->name); ?></div>
                                    <div class="text-[9px] font-black text-sky-500 uppercase tracking-tighter mt-0.5">Verified Profile</div>
                                </div>
                                <a href="<?php echo e(route('customer.profile')); ?>" class="flex items-center gap-3 px-6 py-3 text-xs font-black text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                                    <span>👤</span> View Profile
                                </a>
                                <a href="<?php echo e(route('customer.settings')); ?>" class="flex items-center gap-3 px-6 py-3 text-xs font-black text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                                    <span>⚙️</span> Account Settings
                                </a>
                                <div class="border-t border-slate-50 my-2"></div>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-left flex items-center gap-3 px-6 py-3 text-xs font-black text-rose-500 hover:bg-rose-50 transition-colors">
                                        <span>🚪</span> Terminate Session
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="px-4 md:px-8 pb-10">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('hidden');
            if(sidebar.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }

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
            Toast.fire({
                icon: 'success',
                title: "<?php echo session('success'); ?>"
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Toast.fire({
                icon: 'error',
                title: "<?php echo session('error'); ?>"
            });
        <?php endif; ?>

        <?php if(session('warning')): ?>
            Toast.fire({
                icon: 'warning',
                title: "<?php echo session('warning'); ?>"
            });
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/layouts/customer.blade.php ENDPATH**/ ?>