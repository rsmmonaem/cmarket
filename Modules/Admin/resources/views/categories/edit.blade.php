@extends('layouts.admin')

@section('title', 'Edit Category - C-Market')
@section('page-title', 'Edit Banner')

@section('content')
<div class="max-w-4xl mx-auto space-y-12 animate-fade-in">
    <!-- Header -->
    <div class="card-premium bg-[#0f172a] p-10 md:p-14 text-white border-none shadow-2xl relative overflow-hidden group">
        <div class="relative z-10 lg:w-2/3">
            <h2 class="text-3xl md:text-4xl font-black mb-4 md:mb-6 tracking-tight">Reconfigure Category</h2>
            <p class="text-slate-400 font-medium leading-relaxed text-sm md:text-base">Modify the operational parameters of an existing logic branch. Updates will be synchronized across the global marketplace matrix.</p>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[200px] leading-none select-none italic font-black">CORE</div>
    </div>

    <!-- Reconfiguration Form -->
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Parameters Column -->
            <div class="lg:col-span-2 space-y-8">
                <div class="card-premium p-8 md:p-10 space-y-8">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Node Identifier (Name)</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" required 
                                   class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                            @error('name') <p class="text-[9px] text-rose-500 font-black uppercase mt-1 pl-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Logic Description</label>
                            <textarea name="description" rows="5"
                                      class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">{{ old('description', $category->description) }}</textarea>
                            @error('description') <p class="text-[9px] text-rose-500 font-black uppercase mt-1 pl-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Hierarchy Link (Parent)</label>
                                <select name="parent_id" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                                    <option value="">None (Root Level)</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Process Priority (Sort)</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" 
                                       class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Column -->
            <div class="space-y-8">
                <!-- Image -->
                <div class="card-premium p-8">
                    <h3 class="text-[10px] font-black text-primary uppercase tracking-widest mb-8 text-center">Visual Asset</h3>
                    
                    <div x-data="{ photoName: null, photoPreview: '{{ $category->image ? asset('storage/' . $category->image) : null }}' }" class="flex flex-col items-center">
                        <input type="file" name="image" class="hidden" x-ref="photo"
                               @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                               ">

                        <div class="relative group cursor-pointer" @click="$refs.photo.click()">
                            <div class="w-40 h-40 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800 border-2 border-dashed border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden transition-all group-hover:border-primary"
                                 :class="photoPreview ? 'border-solid border-primary' : ''">
                                
                                <template x-if="!photoPreview">
                                    <div class="text-center p-6 text-slate-400">
                                        <span class="text-4xl block mb-2 opacity-40">📸</span>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Upload Asset</span>
                                    </div>
                                </template>

                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-primary/80 rounded-[2.5rem] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white text-[10px] font-black uppercase tracking-widest">
                                Payment Status
                            </div>
                        </div>
                        <p class="mt-4 text-[8px] font-black text-slate-400 uppercase tracking-widest">Active Buffer</p>
                        @error('image')
                            <p class="mt-4 text-[9px] text-rose-500 font-black uppercase tracking-widest text-center">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Toggle -->
                <div class="card-premium p-8 flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-widest">Live Status</span>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Broadcast Node</p>
                    </div>
                    <div x-data="{ enabled: {{ $category->is_active ? 'true' : 'false' }} }">
                        <input type="hidden" name="is_active" :value="enabled ? '1' : '0'">
                        <button type="button" 
                                @click="enabled = !enabled"
                                :class="enabled ? 'bg-primary' : 'bg-slate-700'"
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out">
                            <span :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-center gap-6 pt-10">
            <a href="{{ route('admin.categories.index') }}" class="btn-matrix bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-800 dark:text-slate-500 dark:hover:text-white">
                Abort Command
            </a>
            <button type="submit" class="btn-matrix btn-primary-matrix px-12">
                Save Category
            </button>
        </div>
    </form>
</div>
@endsection
