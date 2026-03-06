@extends('layouts.admin')

@section('title', 'Deploy New Asset - EcomMatrix')
@section('page-title', 'Promotional Deployment')

@section('content')
<div class="max-w-4xl mx-auto space-y-12 animate-fade-in">
    <!-- Header Node -->
    <div class="card-premium bg-[#0f172a] p-10 md:p-14 text-white border-none shadow-2xl relative overflow-hidden group">
        <div class="relative z-10 lg:w-2/3">
            <h2 class="text-3xl md:text-4xl font-black mb-4 md:mb-6 tracking-tight">Deploy Promotional Asset</h2>
            <p class="text-slate-400 font-medium leading-relaxed text-sm md:text-base">Integrate a new visual node into the frontend infrastructure. Define its position within the platform matrix.</p>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[200px] leading-none select-none italic font-black">PROMO</div>
    </div>

    <!-- Form -->
    <div class="card-premium p-8 md:p-12">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Asset Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter promotional title" 
                               class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                        @error('title') <p class="text-[9px] text-rose-500 font-black uppercase mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Position Protocol</label>
                        <select name="position" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-[11px] font-black text-slate-700 dark:text-white uppercase tracking-widest focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                            <option value="main_banner">Main Banner (Hero Slider)</option>
                            <option value="mid_banner">Mid Page Banner</option>
                            <option value="popup_banner">Popup Banner</option>
                            <option value="footer_banner">Footer Banner</option>
                            <option value="main_section_banner">Main Section Banner</option>
                        </select>
                        @error('position') <p class="text-[9px] text-rose-500 font-black uppercase mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Redirect URL</label>
                        <input type="text" name="link" value="{{ old('link') }}" placeholder="https://..." 
                               class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                        @error('link') <p class="text-[9px] text-rose-500 font-black uppercase mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Asset Image</label>
                        <div x-data="{ photoPreview: null }" class="relative flex flex-col items-center">
                            <input type="file" name="image" required class="hidden" x-ref="photo" 
                                   @change="
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                   ">
                            <div class="w-full h-40 bg-slate-50 dark:bg-slate-800 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-[2rem] flex flex-col items-center justify-center text-center group cursor-pointer hover:border-primary transition-all overflow-hidden"
                                 @click="$refs.photo.click()">
                                <template x-if="!photoPreview">
                                    <div class="text-slate-400">
                                        <span class="text-4xl mb-2 block opacity-40">🖼️</span>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Upload Visual Data</span>
                                    </div>
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>
                        </div>
                        @error('image') <p class="text-[9px] text-rose-500 font-black uppercase mt-1 pl-1 text-center">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Sort Priority</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                   class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-black text-slate-700 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                        </div>

                        <div class="flex flex-col justify-end">
                            <label class="flex items-center justify-between bg-slate-50 dark:bg-slate-800 p-4 px-6 rounded-2xl cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 transition-all border border-slate-100 dark:border-slate-700">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Live Status</span>
                                <div x-data="{ enabled: true }">
                                    <input type="hidden" name="is_active" :value="enabled ? '1' : '0'">
                                    <button type="button" @click="enabled = !enabled"
                                            :class="enabled ? 'bg-primary' : 'bg-slate-600'"
                                            class="relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out">
                                        <span :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-6 pt-10 border-t border-slate-50 dark:border-slate-800">
                <a href="{{ route('admin.banners.index') }}" class="btn-matrix bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-800 dark:text-slate-500 dark:hover:text-white text-center">
                    Abort Mission
                </a>
                <button type="submit" class="btn-matrix btn-primary-matrix px-12">
                    Finalize Deployment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
