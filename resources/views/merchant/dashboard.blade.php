@extends('layouts.customer')

@section('title', 'Merchant Dashboard')
@section('page-title', 'Merchant Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Products</h3>
        <div class="value">{{ Auth::user()->merchant?->products()->count() ?? 0 }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <h3>Total Orders</h3>
        <div class="value">{{ Auth::user()->merchant?->orders()->count() ?? 0 }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
        <h3>Shop Wallet</h3>
        <div class="value">৳{{ number_format(Auth::user()->getWallet('shop')?->balance ?? 0, 2) }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
        <h3>Pending Orders</h3>
        <div class="value">{{ Auth::user()->merchant?->orders()->where('status', 'pending')->count() ?? 0 }}</div>
    </div>
</div>

<h3 style="margin-bottom: 15px; color: #333;">Merchant Dashboard</h3>
<p style="color: #666; line-height: 1.6;">
    Manage your products, orders, and track your sales performance.
</p>

<div style="margin-top: 30px;">
    <h4 style="margin-bottom: 15px; color: #333;">Quick Actions</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">➕</div>
            <div style="font-weight: 600;">Add Product</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📦</div>
            <div style="font-weight: 600;">Manage Products</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🛍️</div>
            <div style="font-weight: 600;">View Orders</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📊</div>
            <div style="font-weight: 600;">Sales Report</div>
        </a>
    </div>
</div>
@endsection
