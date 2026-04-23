<aside class="w-64 bg-white h-screen shadow-md p-5">

    <h2 class="text-lg font-semibold mb-6 text-gray-600">Menu</h2>

    <ul class="space-y-2">

        {{-- DASHBOARD --}}
        <li>
            <a href="/dashboard" 
               class="block p-2 rounded-lg hover:bg-cyan-50 hover:text-cyan-600 transition">
                🏠 Dashboard
            </a>
        </li>

        {{-- ADMIN ONLY --}}
        @if(auth()->user()->role == 'admin')
        <li>
            <a href="/users" 
               class="block p-2 rounded-lg hover:bg-cyan-50 hover:text-cyan-600 transition">
                👤 Data User
            </a>
        </li>
        @endif

        {{-- SEMUA USER --}}
        <li>
            <a href="/books" 
               class="block p-2 rounded-lg hover:bg-cyan-50 hover:text-cyan-600 transition">
                📚 Data Buku
            </a>
        </li>

        {{-- ADMIN ONLY --}}
        @if(auth()->user()->role == 'admin')

        <li>
            <a href="/categories" 
               class="block p-2 rounded-lg hover:bg-cyan-50 hover:text-cyan-600 transition">
                🏷️ Kategori
            </a>
        </li>

        <li>
            <a href="/loans" 
               class="block p-2 rounded-lg hover:bg-cyan-50 hover:text-cyan-600 transition">
                📋 Peminjaman
            </a>
        </li>

        <li>
            <a href="/loans/return" 
               class="block p-2 rounded-lg hover:bg-cyan-50 hover:text-cyan-600 transition">
                🔄 Pengembalian
            </a>
        </li>

        @endif

    </ul>

</aside>