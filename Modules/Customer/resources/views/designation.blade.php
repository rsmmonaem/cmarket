@extends('layouts.customer')

@section('title', 'My Rank & Designation')
@section('page-title', 'My Designation')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card-solid" style="background: linear-gradient(135deg, var(--primary) 0%, #312e81 100%); color: white; padding: 4rem 2rem; border-radius: 2rem; text-align: center; margin-bottom: 3rem;">
        <div style="font-size: 5rem; margin-bottom: 1.5rem;">👑</div>
        <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.1em;">{{ $user->designation->name ?? 'Level 1 Affiliate' }}</h2>
        <div style="font-size: 1rem; opacity: 0.8; font-weight: 500;">
            Next Goal: <strong style="color: #fbbf24;">Silver Partner 🏆</strong>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
        <div class="card-solid" style="padding: 2rem; text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">👥</div>
            <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase;">Direct Line</h3>
            <div style="font-size: 2rem; font-weight: 900; color: var(--primary);">{{ $user->referrals()->count() ?? 0 }}</div>
            <div style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">Total invited customers</div>
        </div>

        <div class="card-solid" style="padding: 2rem; text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">📈</div>
            <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase;">Group Sales</h3>
            <div style="font-size: 2rem; font-weight: 900; color: var(--primary);">৳0.00</div>
            <div style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">Across all referral levels</div>
        </div>

        <div class="card-solid" style="padding: 2rem; text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">💎</div>
            <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase;">Partner Perks</h3>
            <div style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-top: 1rem;">Daily Cashback 🔥</div>
            <div style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">Active for your current rank</div>
        </div>
    </div>
</div>
@endsection
