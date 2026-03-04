@extends('layouts.admin')

@section('title', 'Merchant Management')
@section('page-title', 'Merchant Management')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <x-admin.card class="border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Pending Store Requests</p>
        <h3 class="text-3xl font-black text-light">{{ $merchants->where('status', 'pending')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Active Merchants</p>
        <h3 class="text-3xl font-black text-light">{{ $merchants->where('status', 'approved')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-red-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Suspended Vendors</p>
        <h3 class="text-3xl font-black text-light">{{ $merchants->where('status', 'suspended')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-slate-900 dark:border-l-slate-700">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Total Catalog size</p>
        <h3 class="text-3xl font-black text-light">{{ \App\Models\Product::count() }}</h3>
    </x-admin.card>
</div>

<x-admin.card title="Merchant Directory">
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Business Detail</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Owner Info</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-center">Catalog</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Account Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($merchants as $merchant)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">{{ $merchant->business_name }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-wider">{{ $merchant->business_type }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-light uppercase tracking-tighter">{{ $merchant->user->name }}</div>
                            <div class="text-[10px] text-muted-light font-black">{{ $merchant->phone }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-light border border-light">
                                {{ $merchant->products_count ?? 0 }} PRODUCTS
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($merchant->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> APPROVED VENDOR
                                </span>
                            @elseif($merchant->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PENDING REVIEW
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> SUSPENDED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.merchants.show', $merchant) }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light text-[10px] font-black hover:bg-sky-500 hover:text-white transition uppercase tracking-widest shadow-sm inline-block">
                                Review Profile
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted-light italic">No merchants managed yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($merchants->hasPages())
        <div class="mt-8">{{ $merchants->links() }}</div>
    @endif
</x-admin.card>
@endsection
