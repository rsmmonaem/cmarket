<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Merchant Terminal') - EcomMatrix</title>
    
    <!-- Google Fonts: Outfit for Modern SaaS Look -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb', // Professional Blue
                        'primary-hover': '#1e40af',
                        surface: '#ffffff',
                        background: '#f8fafc',
                        'slate-950': '#0f172a',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    borderRadius: {
                        '3xl': '1.5rem',
                        '4xl': '2rem',
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        
        .card-premium {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-radius: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-premium:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            transform: translateY(-2px);
        }

        .nav-link-active {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            border-right: 4px solid #2563eb;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.5s ease-out; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-slate-900 font-sans" x-data="{ sidebarOpen: true }">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="!sidebarOpen" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = true"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0f172a] text-white transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="h-24 flex items-center px-8 border-b border-white/5">
                <a href="{{ route('merchant.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-2xl flex items-center justify-center text-white text-xl shadow-lg shadow-primary/20">🛒</div>
                    <span class="text-xl font-black tracking-tighter uppercase">Merchant <span class="text-primary">Hub</span></span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto sidebar-scroll px-4 py-8 space-y-8 h-[calc(100vh-96px)]">
                <!-- Section: Core -->
                <div class="space-y-2">
                    <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Core</p>
                    <x-admin.sidebar-link route="merchant.dashboard" icon="📊" label="Dashboard" />
                    
                    <x-admin.sidebar-dropdown icon="🛍️" label="Orders">
                        <x-admin.sidebar-link route="merchant.orders.index" label="All Dispatches" />
                        <x-admin.sidebar-link route="merchant.orders.index" :params="['status' => 'pending']" label="Awaiting Protocol" />
                        <x-admin.sidebar-link route="merchant.orders.index" :params="['status' => 'confirmed']" label="Confirmed Units" />
                        <x-admin.sidebar-link route="merchant.orders.index" :params="['status' => 'packaging']" label="In Assembly" />
                        <x-admin.sidebar-link route="merchant.orders.index" :params="['status' => 'out_for_delivery']" label="Out For Transit" />
                        <x-admin.sidebar-link route="merchant.orders.index" :params="['status' => 'delivered']" label="Deployment Complete" />
                    </x-admin.sidebar-dropdown>

                    <x-admin.sidebar-dropdown icon="📦" label="Products">
                        <x-admin.sidebar-link route="merchant.products.index" label="Inventory List" />
                        <x-admin.sidebar-link route="merchant.products.create" label="Deploy New Unit" />
                        <x-admin.sidebar-link route="merchant.products.index" label="Bulk Ingestion" />
                        <x-admin.sidebar-link route="merchant.products.index" label="Asset Reviews" />
                    </x-admin.sidebar-dropdown>
                </div>

                <!-- Section: Business -->
                <div class="space-y-2">
                    <p class="px-4 text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">E-Commerce</p>
                    
                    <x-admin.sidebar-dropdown icon="🎟️" label="Promotions">
                        <x-admin.sidebar-link route="merchant.dashboard" :params="['section' => 'coupons']" label="Coupon Matrix" />
                        <x-admin.sidebar-link route="merchant.dashboard" :params="['section' => 'flash']" label="Flash Protocol" />
                        <x-admin.sidebar-link route="merchant.dashboard" :params="['section' => 'featured']" label="Featured Deals" />
                    </x-admin.sidebar-dropdown>

                    <x-admin.sidebar-dropdown icon="💬" label="Communications">
                        <x-admin.sidebar-link route="merchant.dashboard" label="Customer Signals" />
                        <x-admin.sidebar-link route="merchant.dashboard" label="Logistics Sync" />
                    </x-admin.sidebar-dropdown>

                    <x-admin.sidebar-dropdown icon="📊" label="Analytics">
                        <x-admin.sidebar-link route="merchant.reports.sales" label="Sales Narrative" />
                        <x-admin.sidebar-link route="merchant.reports.analytics" label="Market Intelligence" />
                    </x-admin.sidebar-dropdown>
                </div>

                <!-- Section: Management -->
                <div class="space-y-2">
                    <p class="px-4 text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Market Presence</p>
                    
                    <x-admin.sidebar-link route="merchant.shop.index" icon="⚙️" label="Shop Configuration" />
                    <x-admin.sidebar-link route="merchant.dashboard" label="Financial Bounds" />
                    <x-admin.sidebar-link route="merchant.dashboard" label="Identity Nodes" />
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            <!-- Top Navigation Matrix -->
            <header class="h-24 bg-white border-b border-slate-100 px-8 flex items-center justify-between flex-shrink-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-3 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">@yield('page-title', 'Overview')</h1>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Notifications -->
                    <div class="relative group">
                        <button class="p-3 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors relative">
                            <span>🔔</span>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
                        </button>
                    </div>

                    <!-- Profile Node -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-4 pl-6 border-l border-slate-100 hover:opacity-80 transition-opacity">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] font-black text-primary uppercase tracking-widest">{{ Auth::user()->merchant->business_name ?? 'Verifying Node' }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 border-2 border-white shadow-sm flex items-center justify-center text-xl overflow-hidden hover:scale-110 transition-transform cursor-pointer">
                                👤
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 top-full mt-4 w-56 bg-white rounded-3xl shadow-2xl border border-slate-100 p-3 z-50">
                            <div class="px-4 py-3 border-b border-slate-50 mb-2">
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Node Primary</p>
                                <p class="text-xs font-black text-slate-800 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('merchant.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-[10px] font-black text-slate-600 uppercase tracking-widest hover:bg-slate-50 hover:text-primary transition-all rounded-2xl">
                                👤 Profile Metrics
                            </a>
                            <div class="border-t border-slate-50 my-2"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-[10px] font-black text-rose-500 uppercase tracking-widest hover:bg-rose-50 transition-all rounded-2xl">
                                    🚪 De-authorize
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Workspace Content -->
            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
