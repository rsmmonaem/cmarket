<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Dashboard') - CMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 260px;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        
        .sidebar {
            width: var(--sidebar-w);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
        }

        .glass-topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
    </style>
</head>
<body class="text-slate-900 overflow-x-hidden">
    <!-- Mobile Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="dashboard-container flex">
        <!-- Minimal Sidebar -->
        <aside id="sidebar" class="sidebar fixed left-0 top-0 bottom-0 z-50 overflow-y-auto bg-slate-900 text-slate-300 border-r border-slate-800">
            <div class="p-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-10 hover:opacity-80 transition-opacity">
                    <span class="w-8 h-8 rounded-lg bg-sky-500 flex items-center justify-center text-sm shadow-lg shadow-sky-500/20 text-white">🛒</span>
                    <span class="text-lg font-black text-white tracking-widest uppercase">CMarket</span>
                </a>
                
                <!-- Nav -->
                <nav class="space-y-1.5" x-data="{ activeMenu: '{{ request()->segment(2) ?? 'dashboard' }}' }">
                    
                    <!-- Single Link: Dashboard -->
                    <a href="{{ route('customer.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('customer.dashboard') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('customer.dashboard') ? 'text-sky-400' : 'text-slate-500' }}">📊</span>
                        Dashboard
                    </a>

                    <!-- Shop Section -->
                    <a href="{{ route('products.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('products.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('products.*') ? 'text-sky-400' : 'text-slate-500' }}">📦</span>
                        Shop
                    </a>

                    <!-- Wallet Section -->
                    <a href="{{ route('wallet.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('wallet.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('wallet.*') ? 'text-sky-400' : 'text-slate-500' }}">💳</span>
                        Wallet
                    </a>

                    <!-- Top-up Section -->
                    <a href="{{ route('customer.topup.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('customer.topup.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('customer.topup.*') ? 'text-sky-400' : 'text-slate-500' }}">📥</span>
                        Top-up
                    </a>

                    <!-- Withdrawal Section -->
                    <a href="{{ route('customer.withdrawals.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('customer.withdrawals.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('customer.withdrawals.*') ? 'text-sky-400' : 'text-slate-500' }}">🏧</span>
                        Withdrawals
                    </a>

                    <!-- Network Section -->
                    <a href="{{ route('referrals.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('referrals.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('referrals.*') ? 'text-sky-400' : 'text-slate-500' }}">🤝</span>
                        Network
                    </a>

                    <!-- Invest Section -->
                    <a href="{{ route('investments.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('investments.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('investments.*') ? 'text-sky-400' : 'text-slate-500' }}">🏗️</span>
                        Invest
                    </a>

                    <!-- Fast Transfer Section -->
                    <a href="{{ route('customer.transfer.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('customer.transfer.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('customer.transfer.*') ? 'text-sky-400' : 'text-slate-500' }}">💸</span>
                        Send Funds
                    </a>

                    <!-- Verification (Keeping for KYC accessibility) -->
                    <a href="{{ route('kyc.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('kyc.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('kyc.*') ? 'text-sky-400' : 'text-slate-500' }}">🆔</span>
                        Verify Identity
                    </a>

                    <!-- Membership Section -->
                    <a href="{{ route('customer.membership.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide
                              {{ request()->routeIs('customer.membership.*') ? 'bg-sky-500/10 text-sky-400' : 'hover:bg-slate-800 hover:text-white' }}">
                        <span class="text-base {{ request()->routeIs('customer.membership.*') ? 'text-sky-400' : 'text-slate-500' }}">🪪</span>
                        Membership Card
                    </a>

                    <!-- Divider -->
                    <div class="my-4 border-t border-slate-800 mx-4"></div>

                    @hasanyrole('upazila|district|division|director')
                    <a href="{{ route('regional.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide hover:bg-slate-800 hover:text-white">
                        <span class="text-base text-slate-500">🌎</span>
                        Regional Admin
                    </a>
                    @endhasanyrole

                    @role('merchant')
                    <!-- Accordion: Merchant Tools -->
                    <div x-data="{ expanded: {{ request()->routeIs('merchant.*') ? 'true' : 'false' }} }">
                        <button @click="expanded = !expanded" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all font-bold text-xs tracking-wide hover:bg-slate-800 hover:text-white" :class="expanded ? 'text-white' : ''">
                            <div class="flex items-center gap-3">
                                <span class="text-base text-slate-500" :class="expanded ? 'text-rose-400' : ''">🏪</span>
                                Business Hub
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="expanded ? 'rotate-180 text-rose-400' : 'text-slate-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="expanded" x-collapse>
                            <div class="pt-1 pb-2 pl-11 space-y-1">
                                <a href="{{ route('merchant.dashboard') }}" class="block py-2 text-xs font-semibold hover:text-white transition-colors {{ request()->routeIs('merchant.dashboard') ? 'text-rose-400' : 'text-slate-400' }}">Shop Status</a>
                                <a href="{{ route('merchant.products.index') }}" class="block py-2 text-xs font-semibold hover:text-white transition-colors {{ request()->routeIs('merchant.products.*') ? 'text-rose-400' : 'text-slate-400' }}">My Products</a>
                                <a href="{{ route('merchant.orders.index') }}" class="block py-2 text-xs font-semibold hover:text-white transition-colors {{ request()->routeIs('merchant.orders.*') ? 'text-rose-400' : 'text-slate-400' }}">Customer Orders</a>
                            </div>
                        </div>
                    </div>
                    @endrole

                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-1 min-h-screen lg:ml-[280px]">
            <!-- Topbar -->
            <header class="glass-topbar sticky top-0 z-30 px-4 py-4 md:px-8 md:py-6 flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <button class="p-2 lg:hidden rounded-xl hover:bg-slate-100 transition" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">@yield('page-title', 'Dashboard')</h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-sky-500">{{ Auth::user()->status }}</div>
                    </div>
                    
                    <div class="relative group">
                        <button class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-lg hover:border-sky-500 hover:shadow-lg hover:shadow-sky-500/10 transition-all duration-300 overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                👤
                            @endif
                        </button>
                        <!-- Dropdown with transparent bridge to maintain hover -->
                        <div class="absolute right-0 top-full pt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <div class="bg-white rounded-[1.5rem] shadow-2xl border border-slate-100 py-4 overflow-hidden">
                                <div class="px-6 py-3 border-b border-slate-50 mb-2">
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ Auth::user()->name }}</div>
                                    <div class="text-[9px] font-black text-sky-500 uppercase tracking-tighter mt-0.5">Verified Profile</div>
                                </div>
                                <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-6 py-3 text-xs font-black text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                                    <span>👤</span> View Profile
                                </a>
                                <a href="{{ route('customer.settings') }}" class="flex items-center gap-3 px-6 py-3 text-xs font-black text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                                    <span>⚙️</span> Account Settings
                                </a>
                                <div class="border-t border-slate-50 my-2"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-3 px-6 py-3 text-xs font-black text-rose-500 hover:bg-rose-50 transition-colors">
                                        <span>🚪</span> Terminate Session
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="px-4 md:px-8 pb-10">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('hidden');
            if(sidebar.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }

        // SweetAlert Notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{!! session('success') !!}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{!! session('error') !!}"
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: "{!! session('warning') !!}"
            });
        @endif
    </script>
</body>
</html>
