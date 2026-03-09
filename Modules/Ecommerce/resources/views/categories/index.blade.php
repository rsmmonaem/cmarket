@extends('layouts.public')

@section('title', 'Taxonomy Matrix - C-Market')

@section('content')
<!-- Header -->
<section class="bg-slate-900 py-12 md:py-16 text-center relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <h1 class="text-3xl md:text-5xl font-black text-white mb-4 tracking-tighter">Shop <span class="text-primary">Categories</span></h1>
        <p class="text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em]">Explore all of our products collections</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($categories as $category)
            <div class="group bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative flex flex-col">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-20 h-20 rounded-3xl bg-slate-50 flex items-center justify-center text-4xl group-hover:scale-110 transition-transform shadow-inner overflow-hidden font-black">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                        @else
                            📂
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-primary transition-colors leading-tight">{{ $category->name }}</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $category->products_count ?? 0 }} Products</p>
                    </div>
                </div>

                <p class="text-slate-500 text-xs font-medium leading-relaxed mb-8">{{ $category->description ?? 'Explore ' . strtolower($category->name) . ' products in our marketplace.' }}</p>
                
                @if($category->children->count() > 0)
                    <div class="space-y-6 pt-8 border-t border-slate-50 mt-auto">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Sub Categories</span>
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
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="flex h-12 w-full bg-slate-900 text-white rounded-xl items-center justify-center text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all active:scale-95 shadow-sm">
                        View Category ➔
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 text-center">
                <div class="text-7xl mb-8 opacity-20">📡</div>
                <h2 class="text-xl font-black text-slate-800 mb-2">No Categories Found</h2>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Categories will appear here soon.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
