@extends('layouts.customer')
@section('title', 'Affiliate Links')
@section('page-title', 'My Affiliate Links')

@section('content')
<div class="space-y-8">
    {{-- Nav --}}
    <div class="flex flex-wrap gap-2">
        @foreach([['affiliate.dashboard','🏠 Dashboard'],['affiliate.links','🔗 Links'],['affiliate.commissions','💰 Commissions'],['affiliate.analytics','📊 Analytics'],['affiliate.withdraw','🏦 Withdraw']] as [$r,$l])
        <a href="{{ route($r) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ request()->routeIs($r) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300' }} transition-all">{{ $l }}</a>
        @endforeach
    </div>

    {{-- Generate Link --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Generate New Link</h3>
        <form action="{{ route('affiliate.links.generate') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
            @csrf
            <select name="product_id" required class="flex-1 px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 text-sm font-bold transition-all">
                <option value="">— Select a product to promote —</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} — ৳{{ number_format($product->price, 2) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap">Generate Link</button>
        </form>
        @if(session('success'))<div class="mt-4 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-sm font-bold">{{ session('success') }}</div>@endif
        @if(session('info'))<div class="mt-4 p-4 bg-blue-50 text-blue-700 rounded-2xl text-sm font-bold">{{ session('info') }}</div>@endif
    </div>

    {{-- Links Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800">
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">All Links ({{ $links->total() }})</h4>
        </div>
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Product</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Affiliate URL</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Clicks</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Conversions</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($links as $link)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4">
                        <div class="text-sm font-black text-slate-800 dark:text-white uppercase truncate max-w-[180px]">{{ $link->product->name }}</div>
                        <div class="text-[10px] text-slate-400">৳{{ number_format($link->product->price, 2) }}</div>
                    </td>
                    <td class="px-8 py-4">
                        <div class="flex items-center gap-3">
                            <code class="text-[10px] font-mono text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 px-3 py-1.5 rounded-xl truncate max-w-[200px]">{{ url('/ref/' . $link->code) }}</code>
                            <button onclick="navigator.clipboard.writeText('{{ url('/ref/' . $link->code) }}'); this.textContent='✓'" class="text-[9px] font-black uppercase text-slate-400 hover:text-indigo-600 transition-colors">Copy</button>
                        </div>
                    </td>
                    <td class="px-8 py-4 text-sm font-black text-slate-800 dark:text-white">{{ number_format($link->clicks) }}</td>
                    <td class="px-8 py-4 text-sm font-black text-emerald-600">{{ number_format($link->conversions) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No links generated yet. Pick a product above.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $links->links() }}</div>
    </div>
</div>
@endsection
