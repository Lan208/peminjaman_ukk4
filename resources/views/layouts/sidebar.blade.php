<aside class="w-72 h-[calc(100vh-73px)] sticky top-[73px] 
              bg-gradient-to-b from-slate-800/50 via-blue-900/50 to-cyan-900/50 
              backdrop-blur-xl border-r border-white/10 shadow-2xl">

    <div class="flex flex-col h-full p-6">
        
        {{-- HEADER SIDEBAR --}}
        <div class="mb-8 text-center">
            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-cyan-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg mb-3">
                <i class="fas fa-ship text-white text-3xl"></i>
            </div>
            <h3 class="text-white font-bold text-lg">Sea Library</h3>
            <p class="text-xs text-cyan-200 mt-1">Sistem Peminjaman Buku</p>
        </div>

        {{-- MENU LIST --}}
        <nav class="flex-1">
            <ul class="space-y-1.5">
                
                {{-- DASHBOARD --}}
                <li>
                    <a href="/dashboard"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-cyan-100 
                              hover:bg-white/10 hover:text-white transition-all duration-300
                              {{ request()->is('dashboard') ? 'bg-white/15 text-white border-l-4 border-cyan-400' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 text-cyan-300"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                {{-- ADMIN ONLY --}}
                @if(auth()->user()->role == 'admin')
                <li>
                    <a href="/users"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-cyan-100 
                              hover:bg-white/10 hover:text-white transition-all duration-300
                              {{ request()->is('users*') ? 'bg-white/15 text-white border-l-4 border-cyan-400' : '' }}">
                        <i class="fas fa-users w-5 text-cyan-300"></i>
                        <span class="font-medium">Data User</span>
                    </a>
                </li>
                @endif

                {{-- BUKU - ALL USERS --}}
                <li>
                    <a href="/books"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-cyan-100 
                              hover:bg-white/10 hover:text-white transition-all duration-300
                              {{ request()->is('books*') ? 'bg-white/15 text-white border-l-4 border-cyan-400' : '' }}">
                        <i class="fas fa-book w-5 text-cyan-300"></i>
                        <span class="font-medium">Data Buku</span>
                    </a>
                </li>

                {{-- ADMIN MENU SECTION --}}
                @if(auth()->user()->role == 'admin')
                
                {{-- DIVIDER --}}
                <li class="pt-4 mt-3">
                    <div class="border-t border-white/10"></div>
                    <p class="text-xs text-cyan-300/60 uppercase tracking-wider mt-4 px-4">Manajemen</p>
                </li>

                <li>
                    <a href="/categories"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-cyan-100 
                              hover:bg-white/10 hover:text-white transition-all duration-300
                              {{ request()->is('categories*') ? 'bg-white/15 text-white border-l-4 border-cyan-400' : '' }}">
                        <i class="fas fa-tags w-5 text-cyan-300"></i>
                        <span class="font-medium">Kategori</span>
                    </a>
                </li>

                {{-- PEMINJAMAN --}}
                <li>
                    <a href="/loans"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-cyan-100 
                              hover:bg-white/10 hover:text-white transition-all duration-300
                              {{ request()->is('loans') ? 'bg-white/15 text-white border-l-4 border-cyan-400' : '' }}">
                        <i class="fas fa-clipboard-list w-5 text-cyan-300"></i>
                        <span class="font-medium">Peminjaman</span>
                    </a>
                </li>

                {{-- PENGEMBALIAN --}}
                <li>
                    <a href="/loans/return"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-cyan-100 
                              hover:bg-white/10 hover:text-white transition-all duration-300
                              {{ request()->is('loans/return') ? 'bg-white/15 text-white border-l-4 border-cyan-400' : '' }}">
                        <i class="fas fa-undo-alt w-5 text-cyan-300"></i>
                        <span class="font-medium">Pengembalian</span>
                    </a>
                </li>

                @endif

            </ul>
        </nav>

        {{-- FOOTER SIDEBAR --}}
        <div class="pt-6 mt-auto border-t border-white/10">
            <div class="flex items-center gap-3 px-2 py-2">
                <div class="w-8 h-8 bg-cyan-500/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-fish text-cyan-300 text-sm"></i>
                </div>
                <div>
                    <p class="text-white text-xs font-medium">Keep Reading</p>
                    <p class="text-cyan-300/50 text-[10px]">© 2024 Sea Library</p>
                </div>
            </div>
        </div>

    </div>

</aside>