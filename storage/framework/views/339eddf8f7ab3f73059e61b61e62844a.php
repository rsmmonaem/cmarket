<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <div class="value"><?php echo e(\App\Models\User::count()); ?></div>
    </div>
    <div class="stat-card" style="border-left-color: #f093fb;">
        <h3>Pending KYC</h3>
        <div class="value"><?php echo e(\App\Models\Kyc::where('status', 'pending')->count()); ?></div>
    </div>
    <div class="stat-card" style="border-left-color: #4facfe;">
        <h3>Total Orders</h3>
        <div class="value"><?php echo e(\App\Models\Order::count()); ?></div>
    </div>
    <div class="stat-card" style="border-left-color: #43e97b;">
        <h3>Active Merchants</h3>
        <div class="value"><?php echo e(\App\Models\Merchant::where('status', 'approved')->count()); ?></div>
    </div>
</div>

<h3 style="margin-bottom: 15px; color: #333;">System Overview</h3>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
    <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #667eea;">
        <h4 style="margin-bottom: 10px; color: #333;">Recent Activity</h4>
        <p style="color: #666;">No recent activity</p>
    </div>
    <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #f093fb;">
        <h4 style="margin-bottom: 10px; color: #333;">Pending Approvals</h4>
        <ul style="list-style: none; color: #666;">
            <li>KYC Verifications: <?php echo e(\App\Models\Kyc::where('status', 'pending')->count()); ?></li>
            <li>Merchant Applications: <?php echo e(\App\Models\Merchant::where('status', 'pending')->count()); ?></li>
            <li>Withdrawal Requests: <?php echo e(\App\Models\Withdrawal::where('status', 'pending')->count()); ?></li>
        </ul>
    </div>
</div>

<div style="margin-top: 30px;">
    <h4 style="margin-bottom: 15px; color: #333;">Quick Actions</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <a href="#" style="padding: 20px; background: #667eea; color: white; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
            <div style="font-size: 2rem; margin-bottom: 10px;">✅</div>
            <div style="font-weight: 600;">Approve KYC</div>
        </a>
        <a href="#" style="padding: 20px; background: #f093fb; color: white; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
            <div style="font-size: 2rem; margin-bottom: 10px;">👥</div>
            <div style="font-weight: 600;">Manage Users</div>
        </a>
        <a href="#" style="padding: 20px; background: #4facfe; color: white; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📊</div>
            <div style="font-weight: 600;">View Reports</div>
        </a>
        <a href="#" style="padding: 20px; background: #43e97b; color: white; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
            <div style="font-size: 2rem; margin-bottom: 10px;">⚙️</div>
            <div style="font-weight: 600;">Settings</div>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>