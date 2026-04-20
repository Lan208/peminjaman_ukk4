<aside class="w-64 bg-white h-screen shadow-md p-5">

    <h2 class="text-lg font-semibold mb-6 text-gray-600">Menu</h2>

    <ul class="space-y-2">

        <li>
            <a href="/dashboard" class="block p-2 rounded-lg">
                🏠 Dashboard
            </a>
        </li>

        {{-- ADMIN ONLY --}}
        @if(auth()->user()->role == 'admin')
        <li>
            <a href="/users" class="block p-2">👤 Data User</a>
        </li>
        @endif

        <li>
            <a href="/books" class="block p-2">📚 Data Buku</a>
        </li>

        {{-- ADMIN ONLY --}}
        @if(auth()->user()->role == 'admin')
        <li>
            <a href="/loans" class="block p-2">📋 Peminjaman</a>
        </li>

        <li>
            <a href="/loans/return" class="block p-2">🔄 Pengembalian</a>
        </li>
        @endif

    </ul>

</aside>