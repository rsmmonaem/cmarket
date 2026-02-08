@extends('layouts.customer')

@section('title', 'Rider Dashboard')
@section('page-title', 'Rider Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Deliveries</h3>
        <div class="value">{{ Auth::user()->rider?->deliveries()->count() ?? 0 }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <h3>Completed Today</h3>
        <div class="value">{{ Auth::user()->rider?->deliveries()->whereDate('delivered_at', today())->count() ?? 0 }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
        <h3>Rider Wallet</h3>
        <div class="value">৳{{ number_format(Auth::user()->getWallet('rider')?->balance ?? 0, 2) }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
        <h3>Pending Deliveries</h3>
        <div class="value">{{ Auth::user()->rider?->deliveries()->where('status', 'assigned')->count() ?? 0 }}</div>
    </div>
</div>

<h3 style="margin-bottom: 15px; color: #333;">Rider Dashboard</h3>
<p style="color: #666; line-height: 1.6;">
    Manage your deliveries and track your earnings.
</p>

<div style="margin-top: 30px;">
    <h4 style="margin-bottom: 15px; color: #333;">Quick Actions</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📦</div>
            <div style="font-weight: 600;">Active Deliveries</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">✅</div>
            <div style="font-weight: 600;">Delivery History</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">💰</div>
            <div style="font-weight: 600;">Earnings</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">⚙️</div>
            <div style="font-weight: 600;">Settings</div>
        </a>
    </div>
</div>
@endsection
