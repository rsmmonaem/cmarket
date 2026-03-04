@extends('layouts.customer')

@section('title', 'My Commissions')
@section('page-title', 'Commissions')

@section('content')
<div class="card-solid">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">Commission History</h2>
        <div style="font-size: 0.875rem; color: var(--text-muted-light);">
            Total Earned: <strong style="color: var(--success); font-weight: 800;">৳{{ number_format(auth()->user()->getWallet('commission')->balance ?? 0, 2) }}</strong>
        </div>
    </div>

    @if($commissions->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="text-align: left; background: var(--bg-light); color: var(--text-muted-light); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="padding: 1rem 1.5rem; border-radius: 0.75rem 0 0 0.75rem;">Source</th>
                        <th style="padding: 1rem 1.5rem;">Amount</th>
                        <th style="padding: 1rem 1.5rem;">Level</th>
                        <th style="padding: 1rem 1.5rem;">Status</th>
                        <th style="padding: 1rem 1.5rem; border-radius: 0 0.75rem 0.75rem 0;">Date</th>
                    </tr>
                </thead>
                <tbody style="color: var(--text-light); font-size: 0.875rem;">
                    @foreach($commissions as $comm)
                        <tr style="border-bottom: 1px solid var(--border-light); transition: background 0.2s;" onmouseover="this.style.background='var(--bg-light)'" onmouseout="this.style.background='white'">
                            <td style="padding: 1.25rem 1.5rem;">
                                From Order #{{ $comm->order->order_number ?? 'N/A' }}
                            </td>
                            <td style="padding: 1.25rem 1.5rem; font-weight: 700; color: var(--primary);">
                                ৳{{ number_format($comm->amount, 2) }}
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                Level {{ $comm->level ?? '1' }}
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span style="padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.1); color: var(--success);">
                                    Disbursed
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; color: var(--text-muted-light);">
                                {{ $comm->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 2.5rem;">
            {{ $commissions->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 5rem 2rem;">
            <div style="font-size: 4rem; margin-bottom: 1.5rem;">💸</div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">No commissions yet</h3>
            <p style="color: var(--text-muted-light); font-size: 0.875rem;">Help others discover our products to start earning rewards.</p>
        </div>
    @endif
</div>
@endsection
