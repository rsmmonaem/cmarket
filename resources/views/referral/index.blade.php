@extends('layouts.customer')

@section('title', 'My Referrals')
@section('page-title', 'Referral Network')

@section('content')
<div class="stats-grid">
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
        <h3>Direct Referrals</h3>
        <div class="value">{{ $directReferrals->count() }}</div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
        <h3>Total Network</h3>
        <div class="value">{{ $allReferrals->count() }}</div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <h3>Total Earnings</h3>
        <div class="value">৳{{ number_format($totalCommissions, 2) }}</div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <h3>Pending Earnings</h3>
        <div class="value">৳{{ number_format($pendingCommissions, 2) }}</div>
    </div>
</div>

<div class="card-solid" style="margin-bottom: 2rem; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
    <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Your Referral Hub</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div>
            <p style="font-size: 0.875rem; opacity: 0.8; margin-bottom: 0.75rem;">REFERRAL CODE</p>
            <div style="background: rgba(255,255,255,0.1); padding: 1.25rem; border-radius: 0.75rem; border: 1px dashed rgba(255,255,255,0.3); display: flex; justify-content: space-between; align-items: center;">
                <code style="font-size: 1.5rem; font-weight: 800; letter-spacing: 0.1em;">{{ auth()->user()->referral_code ?? 'NOT GENERATED' }}</code>
                @if(auth()->user()->referral_code)
                    <button onclick="copyText('{{ auth()->user()->referral_code }}')" class="btn-solid" style="background: white; color: var(--primary); padding: 0.5rem 1rem;">Copy</button>
                @endif
            </div>
            @if(!auth()->user()->referral_code)
                <form action="{{ route('referral.generate') }}" method="POST" style="margin-top: 1rem;">
                    @csrf
                    <button type="submit" class="btn-solid btn-primary-solid" style="background: white; color: var(--primary);">Generate Now</button>
                </form>
            @endif
        </div>
        <div>
            @if(auth()->user()->referral_code)
                <p style="font-size: 0.875rem; opacity: 0.8; margin-bottom: 0.75rem;">SHARING LINK</p>
                <div style="background: rgba(255,255,255,0.1); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2); display: flex; gap: 0.75rem;">
                    <input type="text" readonly value="{{ url('/register?ref=' . auth()->user()->referral_code) }}" style="flex: 1; background: transparent; border: none; color: white; font-size: 0.875rem; outline: none;">
                    <button onclick="copyText('{{ url('/register?ref=' . auth()->user()->referral_code) }}')" style="background: transparent; border: none; color: white; cursor: pointer; font-weight: 700;">COPY</button>
                </div>
            @else
                <p style="font-size: 0.875rem; opacity: 0.8; line-height: 1.6;">Once you generate your code, you'll get a unique link to share with your friends and family.</p>
            @endif
        </div>
    </div>
</div>

<div class="card-solid" style="margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Direct Referrals (Level 1)</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid var(--border-light);">
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Name</th>
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Phone</th>
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Designation</th>
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Joined At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($directReferrals as $referral)
                    <tr style="border-bottom: 1px solid var(--border-light);">
                        <td style="padding: 1rem; font-weight: 600;">{{ $referral->name }}</td>
                        <td style="padding: 1rem;">{{ $referral->phone }}</td>
                        <td style="padding: 1rem;">
                            <span style="padding: 0.25rem 0.75rem; background: var(--bg-light); border-radius: 2rem; font-size: 0.75rem; font-weight: 700; color: var(--primary);">
                                {{ $referral->designation->name ?? 'None' }}
                            </span>
                        </td>
                        <td style="padding: 1rem; color: var(--text-muted-light);">{{ $referral->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-muted-light);">No direct referrals yet. Start your journey!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($allReferrals->count() > 0)
<div class="card-solid">
    <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Complete Referral Network</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid var(--border-light);">
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Lvl</th>
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Member</th>
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Role</th>
                    <th style="padding: 1rem; color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase;">Joined At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allReferrals as $referral)
                    <tr style="border-bottom: 1px solid var(--border-light);">
                        <td style="padding: 1rem;">
                            <span style="font-weight: 800; color: var(--info);">L{{ $referral->level }}</span>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="font-weight: 600;">{{ $referral->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted-light);">{{ $referral->phone }}</div>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="padding: 0.25rem 0.75rem; background: var(--bg-light); border-radius: 2rem; font-size: 0.75rem; font-weight: 700; color: var(--secondary);">
                                {{ $referral->designation->name ?? 'MEMBER' }}
                            </span>
                        </td>
                        <td style="padding: 1rem; color: var(--text-muted-light);">{{ $referral->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<script>
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}
</script>
@endsection
