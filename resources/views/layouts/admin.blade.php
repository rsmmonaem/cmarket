<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - CMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    <script>
        // Theme initialization
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark-mode');
        } else {
            document.documentElement.classList.remove('dark-mode');
        }
    </script>
    <style>
        .sidebar { width: var(--sidebar-w); transition: all 0.3s; }
        .main-content { margin-left: var(--sidebar-w); min-height: 100vh; transition: all 0.3s; }
        .topbar { height: var(--header-h); }
        
        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="bg-light text-light font-sans antialiased">
    <div class="dashboard-container flex">
        <!-- Sidebar -->
        <aside class="sidebar sidebar-solid fixed left-0 top-0 bottom-0 z-50 overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-10">
                    <span class="text-3xl">🚀</span>
                    <span class="text-xl font-black text-white tracking-tighter">CMARKET <span class="text-sky-400">ADMIN</span></span>
                </div>
                
                <nav class="space-y-1">
                    <x-admin.sidebar-link route="admin.dashboard" icon="📊" label="Dashboard" />
                    
                    <div class="pt-4 pb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4">Core Management</div>
                    <x-admin.sidebar-link route="admin.users.index" icon="👥" label="Users" />
                    <x-admin.sidebar-link route="admin.kyc.index" icon="✅" label="KYC Approvals" />
                    <x-admin.sidebar-link route="admin.merchants.index" icon="🏪" label="Merchants" />
                    
                    <div class="pt-4 pb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4">Financials</div>
                    <x-admin.sidebar-link route="admin.wallets.index" icon="💰" label="Wallets" />
                    <x-admin.sidebar-link route="admin.withdrawals.index" icon="💸" label="Withdrawals" />
                    <x-admin.sidebar-link route="admin.commissions.index" icon="💵" label="Commissions" />
                    
                    <div class="pt-4 pb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4">Marketplace</div>
                    <x-admin.sidebar-link route="admin.categories.index" icon="📂" label="Categories" />
                    <x-admin.sidebar-link route="admin.products.index" icon="📦" label="Products" />
                    <x-admin.sidebar-link route="admin.orders.index" icon="🛍️" label="Orders" />
                    
                    <div class="pt-4 pb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4">System</div>
                    <x-admin.sidebar-link route="admin.riders.index" icon="🚴" label="Riders" />
                    <x-admin.sidebar-link route="admin.designations.index" icon="🏆" label="Designations" />
                </nav>
            </div>
            
            <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-slate-800 bg-slate-900/50 backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <button id="theme-toggle" class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white transition">
                        <span id="theme-toggle-dark-icon" class="hidden text-xl">🌙</span>
                        <span id="theme-toggle-light-icon" class="hidden text-xl">☀️</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-300 transition uppercase tracking-widest">Logout</button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-1 p-8">
            <header class="topbar flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-3xl font-black text-light tracking-tight">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-sm text-muted-light">Welcome back, {{ Auth::user()->name }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-light">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-sky-500">{{ Auth::user()->getRoleNames()->first() }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-black shadow-xl">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <div id="content-mount">
                @if(session('success'))
                    <x-admin.alert type="success" class="mb-6">
                        {{ session('success') }}
                    </x-admin.alert>
                @endif

                @if(session('error'))
                    <x-admin.alert type="danger" class="mb-6">
                        {{ session('error') }}
                    </x-admin.alert>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function updateIcons() {
            if (document.documentElement.classList.contains('dark-mode')) {
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            } else {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }

        updateIcons();

        themeToggleBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark-mode');
            const isDark = document.documentElement.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateIcons();
        });
    </script>
</body>
</html>
