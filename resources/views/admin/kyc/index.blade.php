@extends('layouts.admin')

@section('title', 'KYC Verification')
@section('page-title', 'KYC Verification')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <x-admin.card class="border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Pending Review</p>
        <h3 class="text-3xl font-black text-light">{{ $kycs->where('status', 'pending')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Approved</p>
        <h3 class="text-3xl font-black text-light">{{ $kycs->where('status', 'approved')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-red-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Rejected</p>
        <h3 class="text-3xl font-black text-light">{{ $kycs->where('status', 'rejected')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-slate-900 dark:border-l-slate-700">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Total Submissions</p>
        <h3 class="text-3xl font-black text-light">{{ $kycs->total() }}</h3>
    </x-admin.card>
</div>

<x-admin.card title="KYC Verification Queue">
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">User Info</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Document Detail</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Submission Date</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($kycs as $kyc)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">{{ $kyc->user->name }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-tighter">{{ $kyc->user->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-light uppercase tracking-tighter">{{ $kyc->id_type }}</div>
                            <div class="text-[10px] text-muted-light font-black">{{ $kyc->id_number }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-muted-light">{{ $kyc->created_at->format('M d, Y') }}</div>
                            <div class="text-[10px] text-muted-light opacity-60">{{ $kyc->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($kyc->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PENDING REVIEW
                                </span>
                            @elseif($kyc->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> VERIFIED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> REJECTED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.kyc.show', $kyc) }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light text-[10px] font-black hover:bg-sky-500 hover:text-white transition uppercase tracking-widest shadow-sm inline-block">
                                Review Docs
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted-light italic">No pending KYC submissions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kycs->hasPages())
        <div class="mt-8">{{ $kycs->links() }}</div>
    @endif
</x-admin.card>
@endsection
