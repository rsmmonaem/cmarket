<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'CMarket'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0f172a',
                        accent: '#38bdf8',
                    }
                }
            }
        }
    </script>
    
    <style>
        [x-cloak] { display: none !important; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .dark-glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    
    @stack('styles')
</head>

<body class="bg-slate-50 font-sans text-slate-900 selection:bg-sky-100 selection:text-sky-900 pb-24 md:pb-0">
    
    <!-- Header -->
    <header class="sticky top-0 z-40 w-full glass border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black italic text-xl shadow-lg group-hover:scale-110 transition-transform">C</div>
                        <span class="text-xl font-black tracking-tighter text-slate-900">CMARKET</span>
                    </a>
                </div>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 transition">Home</a>
                    <a href="{{ route('products.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 transition">Shop</a>
                    <a href="{{ route('merchants.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 transition">Merchants</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-2 md:gap-4">
                    <button class="p-2.5 rounded-xl hover:bg-slate-100/50 transition relative">
                        <span>🔍</span>
                    </button>
                    @auth
                        <a href="{{ route('customer.dashboard') }}" class="hidden md:flex items-center gap-3 pl-4 border-l border-slate-200">
                            <div class="text-right">
                                <p class="text-[10px] font-black uppercase text-slate-400">Account</p>
                                <p class="text-[11px] font-black text-slate-900">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-lg">👤</div>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-slate-900/10 hover:bg-slate-800 transition">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-6 left-6 right-6 z-50">
        <nav class="dark-glass rounded-[2rem] p-4 flex items-center justify-around shadow-2xl shadow-slate-950/20 border border-white/10 relative transition-all duration-300">
            <!-- Glare effect -->
            <div class="absolute inset-0 bg-gradient-to-tr from-white/5 to-transparent pointer-events-none"></div>

            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 group relative z-10">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center {{ request()->routeIs('home') ? 'bg-sky-500 text-white' : 'text-slate-400 hover:text-white transition' }}">
                    <span class="text-xl">🏠</span>
                </div>
            </a>

            <a href="{{ route('products.index') }}" class="flex flex-col items-center gap-1 group relative z-10">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center {{ request()->routeIs('products.*') ? 'bg-sky-500 text-white' : 'text-slate-400 hover:text-white transition' }}">
                    <span class="text-xl">🛍️</span>
                </div>
            </a>

            <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-1 group relative z-10 p-1 active:scale-90 transition-all duration-200">
                <div class="w-16 h-16 -mt-10 rounded-full bg-slate-900 border-4 border-white flex items-center justify-center text-white shadow-2xl hover:scale-110 active:rotate-12 transition group-hover:shadow-slate-900/40">
                    <span class="text-2xl">🛒</span>
                    <span x-data="{ count: {{ session('cart_count', 0) }} }" 
                          x-show="count > 0" 
                          x-text="count" 
                          data-cart-count
                          class="absolute top-0 right-0 bg-sky-500 text-white text-[9px] font-black rounded-full min-w-[20px] h-[20px] flex items-center justify-center border-2 border-slate-900 shadow-sm translate-x-1 -translate-y-1">
                    </span>
                </div>
            </a>

            <a href="{{ route('wallet.index') }}" class="flex flex-col items-center gap-1 group relative z-10">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center {{ request()->routeIs('wallet.*') ? 'bg-sky-500 text-white' : 'text-slate-400 hover:text-white transition' }}">
                    <span class="text-xl">💳</span>
                </div>
            </a>

            <a href="{{ auth()->check() ? route('customer.dashboard') : route('login') }}" class="flex flex-col items-center gap-1 group relative z-10">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center {{ (request()->routeIs('customer.*') || request()->routeIs('login')) ? 'bg-sky-500 text-white' : 'text-slate-400 hover:text-white transition' }}">
                    <span class="text-xl">👤</span>
                </div>
            </a>
        </nav>
    </div>

    @stack('scripts')
</body>
</html>
