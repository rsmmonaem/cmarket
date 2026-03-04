<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Customer Dashboard'); ?> - CMarket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .sidebar-menu {
            list-style: none;
        }
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.2);
        }
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 20px;
        }
        .topbar {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .topbar h2 {
            color: #333;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-info {
            text-align: right;
        }
        .user-name {
            font-weight: 600;
            color: #333;
        }
        .user-role {
            font-size: 0.85rem;
            color: #666;
        }
        .logout-btn {
            padding: 8px 20px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .logout-btn:hover {
            background: #c0392b;
        }
        .content-area {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .stat-card h3 {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 10px;
        }
        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-logo">
                🚀 CMarket
            </div>
            <ul class="sidebar-menu">
                <li><a href="<?php echo e(route('customer.dashboard')); ?>" class="<?php echo e(request()->routeIs('customer.dashboard') ? 'active' : ''); ?>">📊 Dashboard</a></li>
                <li><a href="#">💰 My Wallets</a></li>
                <li><a href="#">🛍️ My Orders</a></li>
                <li><a href="#">🤝 Referrals</a></li>
                <li><a href="#">📈 Commissions</a></li>
                <li><a href="#">🏆 My Designation</a></li>
                <li><a href="#">📦 Products</a></li>
                <li><a href="#">👤 Profile</a></li>
                <li><a href="#">⚙️ Settings</a></li>
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

            <div class="content-area">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/layouts/customer.blade.php ENDPATH**/ ?>