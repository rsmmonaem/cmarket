@extends('layouts.customer')

@section('title', 'Customer Dashboard')
@section('page-title', 'Customer Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <h3>Main Wallet Balance</h3>
        <div class="value">৳{{ number_format(Auth::user()->getWallet('main')?->balance ?? 0, 2) }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <h3>Cashback Wallet</h3>
        <div class="value">৳{{ number_format(Auth::user()->getWallet('cashback')?->balance ?? 0, 2) }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
        <h3>Commission Wallet</h3>
        <div class="value">৳{{ number_format(Auth::user()->getWallet('commission')?->balance ?? 0, 2) }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
        <h3>Total Orders</h3>
        <div class="value">{{ Auth::user()->orders()->count() }}</div>
    </div>
</div>

<h3 style="margin-bottom: 15px; color: #333;">Welcome to CMarket!</h3>
<p style="color: #666; line-height: 1.6;">
    You're currently a <strong>{{ ucfirst(Auth::user()->status) }}</strong> member. 
    Start shopping, refer friends, and earn commissions!
</p>

@if(Auth::user()->status === 'free')
<div style="margin-top: 20px; padding: 20px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px;">
    <strong>⚠️ Complete KYC Verification</strong>
    <p style="margin-top: 10px; color: #856404;">
        To unlock wallet features and start earning, please complete your KYC verification.
    </p>
    <a href="#" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background: #ffc107; color: #000; text-decoration: none; border-radius: 6px; font-weight: 600;">
        Complete KYC Now
    </a>
</div>
@endif

<div style="margin-top: 30px;">
    <h4 style="margin-bottom: 15px; color: #333;">Quick Actions</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; transition: all 0.3s; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🛍️</div>
            <div style="font-weight: 600;">Browse Products</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; transition: all 0.3s; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">💸</div>
            <div style="font-weight: 600;">Transfer Funds</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; transition: all 0.3s; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🤝</div>
            <div style="font-weight: 600;">Invite Friends</div>
        </a>
        <a href="#" style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; text-align: center; transition: all 0.3s; border: 2px solid #e0e0e0;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📊</div>
            <div style="font-weight: 600;">View Reports</div>
        </a>
    </div>
</div>
@endsection
