<?php $__env->startSection('title', 'Customer Dashboard'); ?>
<?php $__env->startSection('page-title', 'Customer Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="stats-grid">
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
        <h3>Main Wallet Balance</h3>
        <div class="value">৳<?php echo e(number_format(Auth::user()->getWallet('main')?->balance ?? 0, 2)); ?></div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
        <h3>Cashback Wallet</h3>
        <div class="value">৳<?php echo e(number_format(Auth::user()->getWallet('cashback')?->balance ?? 0, 2)); ?></div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <h3>Commission Wallet</h3>
        <div class="value">৳<?php echo e(number_format(Auth::user()->getWallet('commission')?->balance ?? 0, 2)); ?></div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <h3>Total Orders</h3>
        <div class="value"><?php echo e(Auth::user()->orders()->count()); ?></div>
    </div>
</div>

<div class="card-solid" style="margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1rem; font-weight: 700;">Welcome back, <?php echo e(Auth::user()->name); ?>! 👋</h3>
    <p style="color: var(--text-muted-light); line-height: 1.6;">
        You're currently a <strong><?php echo e(ucfirst(Auth::user()->status)); ?></strong> member. 
        Start shopping, refer friends, and earn commissions as you grow in the CMarket ecosystem!
    </p>

    <?php if(Auth::user()->status === 'free'): ?>
    <div style="margin-top: 1.5rem; padding: 1.25rem; background: rgba(245, 158, 11, 0.1); border: 1px solid var(--warning); border-radius: 0.75rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; color: #d97706; font-weight: 700; margin-bottom: 0.5rem;">
            <span>⚠️</span> KYC Verification Pending
        </div>
        <p style="color: #92400e; font-size: 0.875rem; margin-bottom: 1rem;">
            To unlock all wallet features and start earning commissions, please complete your identity verification.
        </p>
        <a href="<?php echo e(route('kyc.index')); ?>" class="btn-solid" style="background-color: var(--warning); color: white;">
            Complete KYC Now
        </a>
    </div>
    <?php endif; ?>
</div>

<div class="card-solid">
    <h4 style="margin-bottom: 1.5rem; font-weight: 700;">Quick Actions</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        <a href="<?php echo e(route('products.index')); ?>" class="card-solid" style="padding: 2rem; text-decoration: none; color: inherit; text-align: center; transition: all 0.3s; background: var(--bg-light); border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🛍️</div>
            <div style="font-weight: 700;">Browse Products</div>
            <p style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">Explore our latest collections</p>
        </a>
        <a href="<?php echo e(route('wallet.index')); ?>" class="card-solid" style="padding: 2rem; text-decoration: none; color: inherit; text-align: center; transition: all 0.3s; background: var(--bg-light); border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">💸</div>
            <div style="font-weight: 700;">Wallet & Funds</div>
            <p style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">Check balance & transfers</p>
        </a>
        <a href="<?php echo e(route('referrals.index')); ?>" class="card-solid" style="padding: 2rem; text-decoration: none; color: inherit; text-align: center; transition: all 0.3s; background: var(--bg-light); border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🤝</div>
            <div style="font-weight: 700;">Invite Friends</div>
            <p style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">Grow your partner network</p>
        </a>
        <a href="#" class="card-solid" style="padding: 2rem; text-decoration: none; color: inherit; text-align: center; transition: all 0.3s; background: var(--bg-light); border: 2px solid transparent;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">📊</div>
            <div style="font-weight: 700;">View Reports</div>
            <p style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">Sales and earnings history</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rsmmonaem/Projects/Nibiz/cmarket/resources/views/customer/dashboard.blade.php ENDPATH**/ ?>