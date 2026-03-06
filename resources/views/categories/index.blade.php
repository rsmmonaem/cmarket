@extends('layouts.public')

@section('title', 'Taxonomy Matrix - EcomMatrix')

@section('content')
<!-- Header Node -->
<section class="bg-slate-900 py-24 text-center relative overflow-hidden">
    <!-- Decor -->
    <div class="absolute inset-0 opacity-10 pointer-events-none rotate-12 flex items-center justify-center">
        <span class="text-[300px] font-black italic text-slate-700">TAXONOMY</span>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 tracking-tighter">Marketplace <span class="text-primary">Taxonomy</span></h1>
        <p class="text-slate-400 text-sm font-bold uppercase tracking-[0.3em]">Explore the global product distribution network nodes</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($categories as $category)
            <div class="group bg-white rounded-[3rem] p-10 border border-slate-100 shadow-soft hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-700 relative flex flex-col">
                <div class="flex items-center gap-6 mb-10">
                    <div class="w-20 h-20 rounded-3xl bg-slate-50 flex items-center justify-center text-4xl group-hover:scale-110 transition-transform shadow-inner overflow-hidden font-black">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                        @else
                            📂
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-primary transition-colors leading-tight">{{ $category->name }}</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $category->products_count ?? 0 }} ACTIVE NODES</p>
                    </div>
                </div>

                <p class="text-slate-500 text-xs font-medium leading-relaxed mb-10">{{ $category->description ?? 'Primary marketplace node for global ' . strtolower($category->name) . ' assets and derivatives.' }}</p>
                
                @if($category->children->count() > 0)
                    <div class="space-y-6 pt-8 border-t border-slate-50 mt-auto">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Level 1 Sub-Nodes</span>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($category->children as $child)
                                <div class="space-y-2">
                                    <a href="{{ route('products.index', ['category' => $child->id]) }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-primary hover:text-white text-[10px] font-bold transition-all group/sub">
                                        <span>{{ $child->name }}</span>
                                        <span class="opacity-0 group-hover/sub:opacity-100 transition-opacity">➔</span>
                                    </a>
                                    
                                    @if($child->children->count() > 0)
                                        <div class="pl-4 space-y-1">
                                            @foreach($child->children as $subChild)
                                                <a href="{{ route('products.index', ['category' => $subChild->id]) }}" class="block text-[8px] font-black text-slate-400 hover:text-primary uppercase tracking-widest transition-colors">
                                                    ● {{ $subChild->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-12">
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="flex h-12 w-full bg-slate-900 text-white rounded-2xl items-center justify-center text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all active:scale-95 shadow-xl shadow-slate-900/10">
                        Access Domain Node ➔
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 text-center">
                <div class="text-7xl mb-8 opacity-20">📡</div>
                <h2 class="text-2xl font-black text-slate-900 mb-4">No Taxonomy Nodes Detected</h2>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Awaiting synchronization with central market infrastructure</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
