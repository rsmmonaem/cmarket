@extends('layouts.customer')

@section('title', 'My Wallets')
@section('page-title', 'My Wallets')

@section('content')
<div class="stats-grid">
    @foreach($wallets as $wallet)
        @php
            $gradient = 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)';
            $icon = '💰';
            if($wallet->wallet_type === 'cashback') {
                $gradient = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
                $icon = '🎁';
            } elseif($wallet->wallet_type === 'commission') {
                $gradient = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                $icon = '💵';
            } elseif($wallet->wallet_type === 'shop') {
                $gradient = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
                $icon = '🏪';
            } elseif($wallet->wallet_type === 'share') {
                $gradient = 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)';
                $icon = '🤝';
            }
        @endphp
        <div class="stat-card-custom" style="background: {{ $gradient }};">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                <h3 style="margin-bottom: 0;">{{ ucfirst($wallet->wallet_type) }} Wallet</h3>
                <span style="font-size: 1.5rem;">{{ $icon }}</span>
            </div>
            <div class="value">৳{{ number_format($wallet->balance, 2) }}</div>
            <div style="font-size: 0.75rem; opacity: 0.7; margin-top: 0.5rem;">
                Status: {{ ucfirst($wallet->status) }}
            </div>
        </div>
    @endforeach
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Recent Transactions -->
    <div class="card-solid">
        <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Recent Transactions</h3>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @php
                $allTransactions = collect();
                foreach($wallets as $wallet) {
                    $allTransactions = $allTransactions->merge($wallet->ledgers);
                }
                $allTransactions = $allTransactions->sortByDesc('created_at')->take(20);
            @endphp

            @forelse($allTransactions as $transaction)
                <div style="padding: 1.25rem; background: var(--bg-light); border-radius: 0.75rem; border: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; border: 1px solid var(--border-light);">
                            {{ $transaction->type === 'credit' ? '📥' : '📤' }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--text-light);">{{ $transaction->description }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted-light);">
                                {{ ucfirst($transaction->wallet->wallet_type) }} • {{ $transaction->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 700; color: {{ $transaction->type === 'credit' ? 'var(--success)' : 'var(--danger)' }}; font-size: 1.125rem;">
                            {{ $transaction->type === 'credit' ? '+' : '-' }}৳{{ number_format($transaction->amount, 2) }}
                        </div>
                        <div style="font-size: 0.75rem; color: var(--text-muted-light);">
                            Bal: ৳{{ number_format($transaction->running_balance, 2) }}
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 3rem; text-align: center; color: var(--text-muted-light);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💳</div>
                    <p>No transactions found in your records.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Transfer -->
    <div>
        <div class="card-solid" style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Fund Transfer</h3>
            <form action="{{ route('wallet.transfer') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-light);">Recipient Phone</label>
                    <input type="text" name="phone" placeholder="01XXXXXXXXX" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light);" required>
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-light);">Wallet Source</label>
                    <select name="wallet_type" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light);" required>
                        @foreach($wallets as $wallet)
                            <option value="{{ $wallet->wallet_type }}">{{ ucfirst($wallet->wallet_type) }} (৳{{ number_format($wallet->balance, 2) }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-light);">Amount (৳)</label>
                    <input type="number" name="amount" min="1" step="0.01" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light);" required>
                </div>
                <button type="submit" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center;">
                    Send Money 🚀
                </button>
            </form>
        </div>

        <!-- Referral Promo -->
        <div class="stat-card-custom" style="background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);">
            <h3 style="color: white; opacity: 1; font-weight: 700; font-size: 1rem; margin-bottom: 1rem;">Invite & Earn</h3>
            <p style="font-size: 0.875rem; opacity: 0.9; line-height: 1.5; margin-bottom: 1.5rem;">
                Invite your family and friends to join CMarket using your code.
            </p>
            <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 0.75rem; border: 1px dashed rgba(255,255,255,0.4); text-align: center;">
                <div style="font-size: 0.75rem; opacity: 0.8; margin-bottom: 0.5rem;">YOUR CODE</div>
                <div style="font-size: 1.5rem; font-weight: 800; letter-spacing: 0.1em;">{{ auth()->user()->referral_code ?? '---' }}</div>
            </div>
            <a href="{{ route('referrals.index') }}" style="display: block; text-align: center; margin-top: 1.5rem; color: white; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                Manage Referrals →
            </a>
        </div>
    </div>
</div>
@endsection
