<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'C-Market - Global Multi-Merchant Marketplace')</title>
    <meta name="description" content="@yield('meta_description', 'C-Market is a premium global multi-merchant marketplace infrastructure for modern commerce.')">
    @stack('meta')
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6B2C',
                        'primary-hover': '#e85a1e',
                        dark: '#0B1B2B',
                        light: '#F5F7FA',
                        accent: '#4DA3FF',
                        surface: '#ffffff',
                        background: '#F5F7FA',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    borderRadius: {
                        'xl': '12px',
                        '2xl': '16px',
                        '3xl': '24px',
                    },
                    spacing: {
                        '18': '4.5rem',
                    }
                }
            }
        }
    </script>
    <style>
        :root { --primary: #FF6B2C; --dark: #0B1B2B; --light: #F5F7FA; --accent: #4DA3FF; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .gradient-primary { background: linear-gradient(135deg, #FF6B2C 0%, #ff8e52 100%); }
        .transition-standard { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-shadow { box-shadow: 0 4px 20px -2px rgba(11, 27, 43, 0.05); }
        .card-shadow-hover:hover { box-shadow: 0 10px 30px -5px rgba(11, 27, 43, 0.1); transform: translateY(-6px); }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .icon-size { width: 20px; height: 20px; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-slate-900 font-sans selection:bg-primary selection:text-white">
    <!-- Top Bar -->
    <div class="bg-slate-900 text-white py-2.5 px-4 sm:px-6 lg:px-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto flex justify-between items-center text-[10px] sm:text-[11px] font-bold uppercase tracking-widest">
            <div class="flex items-center gap-6">
                <span class="hidden md:flex items-center gap-2">
                    <span class="text-primary text-sm">📞</span> +880 1700-000000
                </span>
                <div class="flex items-center gap-4">
                    <select class="bg-transparent border-none focus:ring-0 cursor-pointer hover:text-primary transition-colors pr-4">
                        <option class="text-slate-900">English</option>
                        <option class="text-slate-900">Bangla</option>
                    </select>
                </div>
            </div>
            
            <div class="hidden lg:block">
                <span class="animate-pulse bg-primary/20 text-primary px-3 py-1 rounded-full text-[9px]">
                    🔥 FREE SHIPPING ON ORDERS OVER ৳1000
                </span>
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('merchant.register') }}" class="hover:text-primary transition-colors">Seller Zone</a>
                <a href="#" class="hover:text-primary transition-colors">Order Tracker</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-100 h-[80px] flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex items-center justify-between gap-8">
                <!-- Mobile Menu Button -->
                <button class="lg:hidden text-dark hover:text-primary transition-standard text-2xl h-11 w-11 flex items-center justify-center rounded-xl bg-slate-50">
                    ☰
                </button>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 group">
                    <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center text-white text-xl shadow-lg shadow-primary/20 group-hover:rotate-12 transition-standard">
                        🧩
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-dark">C-Market</span>
                </a>

                <!-- Centered Search Bar -->
                <div class="flex-1 max-w-xl hidden lg:block group">
                    <form action="{{ route('products.search') }}" method="GET" class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search premium marketplace..." 
                               class="w-full bg-slate-50 border-none rounded-xl py-3.5 pl-6 pr-14 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-standard font-medium text-slate-700 placeholder:text-slate-400">
                        <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center hover:bg-primary-hover transition-standard shadow-lg shadow-primary/20 hover:scale-105">
                            <span class="text-lg">🔍</span>
                        </button>
                    </form>
                </div>

                <!-- Icons with 24px spacing -->
                <div class="flex items-center gap-6">
                    @auth
                        <div class="relative group/user">
                            <a href="{{ route('customer.dashboard') }}" class="flex flex-col items-center group hover:text-primary transition-standard">
                                <span class="text-xl mb-0.5 group-hover:scale-110 transition-standard">👤</span>
                                <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block">Profile</span>
                            </a>
                            <div class="absolute right-0 top-full pt-4 opacity-0 invisible group-hover/user:opacity-100 group-hover/user:visible transition-standard">
                                <div class="bg-white rounded-xl shadow-2xl border border-slate-50 p-6 min-w-[220px]">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Account</p>
                                    <div class="space-y-3">
                                        <a href="{{ route('customer.dashboard') }}" class="block text-sm font-bold text-dark hover:text-primary transition-standard">Dashboard</a>
                                        <a href="{{ route('orders.index') }}" class="block text-sm font-bold text-dark hover:text-primary transition-standard">Orders</a>
                                        @role('super-admin|admin')
                                            <a href="{{ route('admin.dashboard') }}" class="block text-sm font-bold text-primary hover:text-primary-hover">Admin Panel</a>
                                        @endrole
                                        <hr class="border-slate-50 my-2">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-left text-sm font-black text-rose-500 uppercase tracking-widest pt-2">Log Out</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex flex-col items-center group hover:text-primary transition-standard">
                            <span class="text-xl mb-0.5 group-hover:scale-110 transition-standard">🔑</span>
                            <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block">Log In</span>
                        </a>
                    @endauth

                    <a href="#" class="flex flex-col items-center group hover:text-primary transition-standard">
                        <span class="text-xl mb-0.5 group-hover:scale-110 transition-standard">🤍</span>
                        <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block text-slate-500">Wishlist</span>
                    </a>

                    {{-- Cart Hover Dropdown --}}
                    <div class="relative" x-data="miniCart()" @mouseenter="open=true" @mouseleave="open=false">
                        <a href="{{ route('cart.index') }}" class="flex flex-col items-center group hover:text-primary transition-standard relative">
                            <span class="text-xl mb-0.5 group-hover:scale-110 transition-standard">🛒</span>
                            <span class="text-[9px] font-black uppercase tracking-tighter hidden sm:block text-slate-500">Cart</span>
                            <span x-show="count > 0"
                                  x-text="count"
                                  data-cart-count
                                  class="absolute -top-1.5 -right-1.5 bg-primary text-white text-[8px] font-black rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 border-2 border-white shadow-md"
                                  style="{{ session('cart_count', 0) > 0 ? 'display:flex;' : 'display:none;' }}">{{ session('cart_count', 0) ?: '' }}</span>
                        </a>

                        {{-- Mini Cart Dropdown --}}
                        <div x-show="open && items.length > 0"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-100 z-50 overflow-hidden"
                             style="display:none;">
                            <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">Your Cart</span>
                                <span class="text-xs text-slate-400 font-semibold" x-text="count + ' item' + (count !== 1 ? 's' : '')"></span>
                            </div>

                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-50 p-2">
                                <template x-for="item in items" :key="item.id">
                                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                            <img :src="item.image" class="w-full h-full object-cover" x-on:error="$el.src='https://placehold.co/48?text=?'">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-slate-800 truncate" x-text="item.name"></p>
                                            <p class="text-[10px] text-slate-400">
                                                <span x-text="'× ' + item.quantity"></span> &middot;
                                                <span class="text-primary font-semibold" x-text="'৳' + item.subtotal.toLocaleString()"></span>
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/60 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Subtotal</p>
                                    <p class="text-sm font-bold text-slate-900" x-text="'৳' + total.toLocaleString()"></p>
                                </div>
                                <a href="{{ route('cart.index') }}"
                                   class="px-5 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-primary transition-colors">
                                    View Cart →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

        <!-- Global Navigation Hierarchy -->
        <nav class="bg-slate-50 border-t border-slate-100 hidden lg:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center gap-8 h-12">
                    <div class="relative group/cat h-full">
                        <button class="flex items-center gap-3 bg-primary text-white px-8 h-full font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-orange-500/10 active:scale-95 transition-transform">
                            <span>☰</span> Browse Categories
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-8 h-full">
                        <a href="{{ route('home') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group {{ request()->routeIs('home') ? 'text-primary' : '' }}">
                            Home
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full {{ request()->routeIs('home') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-opacity"></span>
                        </a>
                        <a href="#" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group">
                            Brands
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full opacity-0 group-hover:opacity-100 transition-all"></span>
                        </a>
                        <a href="{{ route('products.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group">
                            Flash Deals
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full opacity-0 group-hover:opacity-100 transition-all"></span>
                        </a>
                        <a href="{{ route('merchants.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all relative group">
                            All Merchants
                            <span class="absolute -bottom-[14px] left-0 w-full h-1 bg-primary rounded-t-full opacity-0 group-hover:opacity-100 transition-all"></span>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    <a href="{{ route('merchant.register') }}" class="text-[10px] font-black text-primary uppercase tracking-[0.2em] hover:brightness-110">
                        🚀 Start Selling
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Content Matrix -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Global Footer Matrix -->
    <footer class="bg-dark text-white mt-32 relative overflow-hidden border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16">
                <!-- Brand Info -->
                <div class="space-y-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center text-white text-xl">
                            🧩
                        </div>
                        <span class="text-2xl font-black tracking-tighter">Ecom<span class="text-primary">Matrix</span></span>
                    </a>
                    <p class="text-slate-400 text-sm font-medium leading-[1.8] max-w-xs">
                        The ultimate high-fidelity multi-merchant marketplace platform. Built for global scale and professional commerce operations.
                    </p>
                    <div class="flex gap-4">
                        @foreach(['FB', 'TW', 'IG', 'YT'] as $sc)
                            <span class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-400 hover:bg-primary hover:text-white transition-standard cursor-pointer shadow-lg hover:scale-110 active:scale-95">
                                {{ $sc }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Nodes -->
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-10 text-primary">Quick Links</h4>
                    <ul class="space-y-5 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-standard hover:pl-2">Global Inventory</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-white transition-standard hover:pl-2">Categories</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-standard hover:pl-2">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-standard hover:pl-2">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Strategic Pipelines -->
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-10 text-primary">Merchant Operations</h4>
                    <ul class="space-y-5 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <li><a href="{{ route('merchant.register') }}" class="hover:text-white transition-standard hover:pl-2">Merchant Onboarding</a></li>
                        <li><a href="{{ route('rider.register') }}" class="hover:text-white transition-standard hover:pl-2">Logistical Network</a></li>
                        <li><a href="{{ route('affiliate.register') }}" class="hover:text-white transition-standard hover:pl-2">Affiliate Nodes</a></li>
                    </ul>
                </div>

                <!-- Newsletter Node -->
                <div class="space-y-8">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-10 text-primary">Newsletter</h4>
                    <p class="text-slate-400 text-xs font-bold">STAY SYNCHRONIZED WITH LATEST RELEASES</p>
                    <form class="flex flex-col gap-3">
                        <input type="email" placeholder="Enter session email" 
                               class="bg-slate-800 border border-slate-700/50 rounded-xl px-5 py-4 text-xs font-bold focus:ring-4 focus:ring-primary/20 placeholder:text-slate-500 transition-standard">
                        <button type="submit" class="bg-primary hover:bg-primary-hover px-10 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/10 active:scale-95 transition-standard">
                            Subscribe Now
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-slate-800/50 mt-24 pt-12 flex flex-col lg:flex-row justify-between items-center gap-10 text-slate-500 text-[9px] font-black uppercase tracking-[0.2em]">
                <div class="flex items-center gap-4">
                    <span>&copy; {{ date('Y') }} C-Market.</span>
                    <span class="hidden md:block opacity-20">|</span>
                    <span class="hidden md:block">ALL RIGHTS RESERVED</span>
                </div>
                
                <div class="flex gap-12">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Cookie Data</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // ─── Global Toast ─────────────────────────────────────────────────────────────
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    // ─── Global addToCart function ────────────────────────────────────────────────
    function addToCart(productId) {
        @guest
            Swal.fire({
                title: 'Login Required',
                text: 'Please login to add items to your cart.',
                icon: 'info',
                confirmButtonText: 'Login',
                confirmButtonColor: '#FF6B2C',
                showCancelButton: true,
            }).then(result => {
                if (result.isConfirmed) window.location.href = '{{ route("login") }}';
            });
            return;
        @endguest

        // Animate button feedback
        const btn = event?.currentTarget;
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '⏳ Adding...';
        }

        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '🛒 Add to Cart';
            }

            if (data.success) {
                // ✅ SweetAlert toast — different icon for duplicate vs new
                Toast.fire({
                    icon: data.is_duplicate ? 'info' : 'success',
                    title: data.message
                });

                // ✅ Update cart counter badge immediately
                const badges = document.querySelectorAll('[data-cart-count]');
                badges.forEach(el => {
                    el.textContent = data.cart_count;
                    el.style.display = data.cart_count > 0 ? 'flex' : 'none';
                });

                // ✅ Dispatch event for Alpine miniCart
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));

            } else {
                Toast.fire({ icon: 'error', title: data.message || 'Could not add to cart.' });
                if (btn) btn.innerHTML = '🛒 Add to Cart';
            }
        })
        .catch(() => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '🛒 Add to Cart';
            }
            Toast.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
        });
    }

    // ─── Alpine miniCart component ─────────────────────────────────────────────
    function miniCart() {
        return {
            open: false,
            count: {{ session('cart_count', 0) }},
            items: [],
            total: 0,

            init() {
                this.fetchCart();
                window.addEventListener('cart-updated', (e) => {
                    this.count = e.detail.cart_count ?? this.count;
                    this.items = e.detail.cart_items ?? this.items;
                    this.total = e.detail.cart_total ?? this.total;
                });
            },

            fetchCart() {
                fetch('/cart/summary', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(data => {
                    this.count = data.count;
                    this.items = data.items;
                    this.total = data.total;
                })
                .catch(() => {});
            }
        }
    }
    </script>
</body>
</html>

