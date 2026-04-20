<aside class="w-64 bg-white h-screen shadow-md p-5">

    <h2 class="text-lg font-semibold mb-6 text-gray-600">Menu</h2>

    <ul class="space-y-2">

        <!-- DASHBOARD -->
        <li>
            <a href="/dashboard" 
               class="block p-2 rounded-lg transition 
               {{ request()->is('dashboard') ? 'bg-cyan-500 text-white' : 'hover:bg-cyan-100 text-gray-700' }}">
                🏠 Dashboard
            </a>
        </li>

        <!-- USERS -->
        <li>
            <a href="/users" 
               class="block p-2 rounded-lg transition 
               {{ request()->is('users*') ? 'bg-cyan-500 text-white' : 'hover:bg-cyan-100 text-gray-700' }}">
                👤 Data User
            </a>
        </li>

        <!-- BUKU -->
        <li>
            <a href="/books" 
               class="block p-2 rounded-lg transition
               {{ request()->is('books*') ? 'bg-cyan-500 text-white' : 'hover:bg-cyan-100 text-gray-700' }}">
                📚 Data Buku
            </a>
        </li>

        <!-- ADMIN MENU -->
        @if(auth()->check() && auth()->user()->role == 'admin')

            <!-- PEMINJAMAN -->
            <li>
                <a href="/loans" 
                   class="block p-2 rounded-lg transition
                   {{ request()->is('loans') ? 'bg-cyan-500 text-white' : 'hover:bg-cyan-100 text-gray-700' }}">
                    📋 Peminjaman
                </a>
            </li>

            <!-- PENGEMBALIAN -->
            <li>
                <a href="/loans/return" 
                   class="block p-2 rounded-lg transition
                   {{ request()->is('loans/return') ? 'bg-cyan-500 text-white' : 'hover:bg-cyan-100 text-gray-700' }}">
                    🔄 Pengembalian
                </a>
            </li>

        @endif

    </ul>

</aside>