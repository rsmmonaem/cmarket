<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Customer Dashboard'); ?> - CMarket</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-custom.css')); ?>">
    <style>
        :root {
            --sidebar-w: 280px;
            --primary-gradient: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            --active-gradient: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 100%);
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-w);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 2rem;
            min-height: 100vh;
            background-color: var(--bg-light);
        }
        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 900;
            padding: 2.5rem 1.5rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.02em;
            text-decoration: none;
        }
        .sidebar-logo span {
            background: var(--info);
            padding: 0.5rem;
            border-radius: 0.75rem;
            font-size: 1.25rem;
        }
        .sidebar-menu {
            padding: 0 1rem;
            list-style: none;
        }
        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }
        .sidebar-link {
            padding: 0.875rem 1.25rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .sidebar-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(4px);
        }
        .sidebar-link.active {
            color: #3b82f6;
            background: var(--active-gradient);
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background: #3b82f6;
            border-radius: 0 4px 4px 0;
            box-shadow: 4px 0 10px rgba(59, 130, 246, 0.5);
        }
        .menu-label {
            padding: 1.5rem 1.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        /* Topbar & Other existing styles */
        .topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            padding: 1rem 2rem;
            border-radius: 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
        .user-info { text-align: right; }
        .user-name { font-weight: 700; color: var(--text-light); }
        .user-role { font-size: 0.75rem; color: #64748b; font-weight: 600; }
        .logout-btn {
            background: #fee2e2;
            color: #ef4444;
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .logout-btn:hover { background: #fecaca; transform: scale(1.02); }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar sidebar-solid">
            <a href="<?php echo e(route('home')); ?>" class="sidebar-logo">
                <span>🛒</span> CMarket
            </a>
            
            <div class="menu-label">Main Personal</div>
            <ul class="sidebar-menu">
                <li><a href="<?php echo e(route('customer.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('customer.dashboard') ? 'active' : ''); ?>">📊 Dashboard</a></li>
                <li><a href="<?php echo e(route('wallet.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('wallet.*') ? 'active' : ''); ?>">💰 My Wallets</a></li>
                <li><a href="<?php echo e(route('orders.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('orders.*') ? 'active' : ''); ?>">🛍️ My Orders</a></li>
                <li><a href="<?php echo e(route('referrals.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('referrals.*') ? 'active' : ''); ?>">🤝 Referrals</a></li>
            </ul>

            <div class="menu-label">Earnings & Rank</div>
            <ul class="sidebar-menu">
                <li><a href="<?php echo e(route('customer.commissions')); ?>" class="sidebar-link <?php echo e(request()->routeIs('customer.commissions') ? 'active' : ''); ?>">📈 Commissions</a></li>
                <li><a href="<?php echo e(route('customer.designation')); ?>" class="sidebar-link <?php echo e(request()->routeIs('customer.designation') ? 'active' : ''); ?>">🏆 My Designation</a></li>
                <li><a href="<?php echo e(route('kyc.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('kyc.*') ? 'active' : ''); ?>">🆔 KYC Verification</a></li>
            </ul>

            <div class="menu-label">Market & Settings</div>
            <ul class="sidebar-menu">
                <li><a href="<?php echo e(route('products.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">📦 Products</a></li>
                <li><a href="<?php echo e(route('customer.profile')); ?>" class="sidebar-link <?php echo e(request()->routeIs('customer.profile') ? 'active' : ''); ?>">👤 Profile</a></li>
                <li><a href="<?php echo e(route('customer.settings')); ?>" class="sidebar-link <?php echo e(request()->routeIs('customer.settings') ? 'active' : ''); ?>">⚙️ Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h2><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-name"><?php echo e(Auth::user()->name); ?></div>
                        <div class="user-role"><?php echo e(Auth::user()->status); ?></div>
                    </div>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/layouts/customer.blade.php ENDPATH**/ ?>