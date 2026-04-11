<div x-data="userSearch()" class="relative">
    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Recipient (Name / Referral ID / Phone)</label>
    <div class="relative">
        <input 
            type="text" 
            x-model="search" 
            @input.debounce.300ms="fetchUsers"
            @focus="showDropdown = true"
            placeholder="Search recipient..." 
            class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-sky-500 focus:bg-white transition-all outline-none"
        >
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
            <template x-if="loading">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </template>
            <template x-if="!loading">
                <span>🔍</span>
            </template>
        </div>
    </div>

    <!-- Dropdown -->
    <div 
        x-show="showDropdown && (users.length > 0 || noResults)" 
        @click.away="showDropdown = false"
        class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 max-h-64 overflow-y-auto"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
    >
        <template x-if="users.length > 0">
            <div class="p-2 space-y-1">
                <template x-for="user in users" :key="user.id">
                    <button 
                        @click="selectUser(user)"
                        class="w-full text-left px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors group"
                    >
                        <div class="text-sm font-black text-slate-800" x-text="user.name"></div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[9px] font-black uppercase bg-slate-100 text-slate-500 px-2 py-0.5 rounded" x-text="user.referral_code"></span>
                            <span class="text-[10px] font-bold text-slate-400" x-text="user.phone"></span>
                        </div>
                    </button>
                </template>
            </div>
        </template>
        <template x-if="noResults">
            <div class="p-6 text-center text-slate-400 text-xs font-bold">No users found matching your search.</div>
        </template>
    </div>

    <input type="hidden" name="recipient_id" x-model="selectedUserId" required>
</div>

<script>
function userSearch() {
    return {
        search: '',
        users: [],
        loading: false,
        showDropdown: false,
        noResults: false,
        selectedUserId: '',
        
        async fetchUsers() {
            if (this.search.length < 3) {
                this.users = [];
                this.noResults = false;
                return;
            }
            
            this.loading = true;
            try {
                const response = await fetch(`/api/users/search?q=${this.search}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                this.users = data;
                this.noResults = data.length === 0;
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
                this.showDropdown = true;
            }
        },
        
        selectUser(user) {
            this.search = `${user.name} (${user.referral_code})`;
            this.selectedUserId = user.id;
            this.showDropdown = false;
            this.users = [];
        }
    }
}
</script>
