@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">
                        Data User
                    </h2>
                    <p class="text-cyan-200 text-sm mt-1">
                        Kelola data anggota perpustakaan
                    </p>
                </div>
            </div>

            <button onclick="openModal('addModal')" 
                class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2.5 rounded-xl shadow-md transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-plus-circle"></i>
                Tambah User
            </button>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="p-4 text-left text-cyan-200 font-medium">No</th>
                        <th class="p-4 text-left text-cyan-200 font-medium">Nama</th>
                        <th class="p-4 text-left text-cyan-200 font-medium">Email</th>
                        <th class="p-4 text-left text-cyan-200 font-medium">Role</th>
                        <th class="p-4 text-left text-cyan-200 font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $u)
                    <tr class="border-b border-white/10 hover:bg-white/5 transition-all duration-200">
                        <td class="p-4 text-white">{{ $loop->iteration }}</td>
                        <td class="p-4 font-medium text-white">{{ $u->name }}</td>
                        <td class="p-4 text-cyan-200">{{ $u->email }}</td>
                        <td class="p-4">
                            @if($u->role == 'admin')
                                <span class="bg-purple-500/30 text-purple-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit">
                                    <i class="fas fa-crown text-xs"></i>
                                    Admin
                                </span>
                            @else
                                <span class="bg-cyan-500/30 text-cyan-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit">
                                    <i class="fas fa-user text-xs"></i>
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <!-- EDIT -->
                                <button onclick="openModal('editModal{{ $u->id }}')" 
                                    class="text-cyan-300 hover:text-cyan-100 transition flex items-center gap-1">
                                    <i class="fas fa-edit"></i>
                                    <span class="hidden sm:inline">Edit</span>
                                </button>

                                <!-- DELETE -->
                                <form action="/users/{{ $u->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user {{ $u->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 transition flex items-center gap-1">
                                        <i class="fas fa-trash-alt"></i>
                                        <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT --}}
                    <div id="editModal{{ $u->id }}" 
                        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">

                        <div class="bg-gradient-to-br from-white to-cyan-50 rounded-2xl w-96 shadow-2xl animate-fade-in">
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-4 border-b border-cyan-200 pb-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-user-edit text-white"></i>
                                    </div>
                                    <h2 class="font-bold text-cyan-800 text-lg">Edit User</h2>
                                </div>

                                <form method="POST" action="/users/{{ $u->id }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-4">
                                        <label class="text-xs text-cyan-700 font-medium block mb-1">
                                            <i class="fas fa-user mr-1"></i> Nama
                                        </label>
                                        <input type="text" name="name" value="{{ $u->name }}" 
                                            class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-xs text-cyan-700 font-medium block mb-1">
                                            <i class="fas fa-envelope mr-1"></i> Email
                                        </label>
                                        <input type="email" name="email" value="{{ $u->email }}" 
                                            class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-xs text-cyan-700 font-medium block mb-1">
                                            <i class="fas fa-key mr-1"></i> Password (kosongkan jika tidak diubah)
                                        </label>
                                        <input type="password" name="password" placeholder="Password baru" 
                                            class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    </div>

                                    <div class="mb-5">
                                        <label class="text-xs text-cyan-700 font-medium block mb-1">
                                            <i class="fas fa-badge mr-1"></i> Role
                                        </label>
                                        <select name="role" 
                                            class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                            <option value="user" {{ $u->role == 'user' ? 'selected' : '' }}>📖 User</option>
                                            <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>⚙️ Admin</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="button" onclick="closeModal('editModal{{ $u->id }}')" 
                                            class="text-gray-500 hover:text-gray-700 px-4 py-2 rounded-xl transition">
                                            Batal
                                        </button>
                                        <button class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2 rounded-xl transition shadow-md">
                                            <i class="fas fa-save mr-1"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- KOSONG --}}
        @if($users->count() == 0)
        <div class="text-center py-12">
            <i class="fas fa-users-slash text-5xl text-cyan-300/50 mb-3"></i>
            <p class="text-cyan-200">Belum ada user. Silakan tambah user baru.</p>
        </div>
        @endif

    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="addModal" 
    class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-gradient-to-br from-white to-cyan-50 rounded-2xl w-96 shadow-2xl animate-fade-in">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4 border-b border-cyan-200 pb-3">
                <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <h2 class="font-bold text-cyan-800 text-lg">Tambah User</h2>
            </div>

            <form method="POST" action="/users">
                @csrf

                <div class="mb-4">
                    <label class="text-xs text-cyan-700 font-medium block mb-1">
                        <i class="fas fa-user mr-1"></i> Nama
                    </label>
                    <input type="text" name="name" placeholder="Masukkan nama" 
                        class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </div>

                <div class="mb-4">
                    <label class="text-xs text-cyan-700 font-medium block mb-1">
                        <i class="fas fa-envelope mr-1"></i> Email
                    </label>
                    <input type="email" name="email" placeholder="Masukkan email" 
                        class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </div>

                <div class="mb-4">
                    <label class="text-xs text-cyan-700 font-medium block mb-1">
                        <i class="fas fa-lock mr-1"></i> Password
                    </label>
                    <input type="password" name="password" placeholder="Masukkan password" 
                        class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </div>

                <div class="mb-5">
                    <label class="text-xs text-cyan-700 font-medium block mb-1">
                        <i class="fas fa-badge mr-1"></i> Role
                    </label>
                    <select name="role" 
                        class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="user">📖 User</option>
                        <option value="admin">⚙️ Admin</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal('addModal')" 
                        class="text-gray-500 hover:text-gray-700 px-4 py-2 rounded-xl transition">
                        Batal
                    </button>
                    <button class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2 rounded-xl transition shadow-md">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

// Tutup modal klik di luar
window.onclick = function(event) {
    if (event.target.classList.contains('bg-black/50')) {
        event.target.classList.add('hidden');
    }
}
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.animate-fade-in {
    animation: fade-in 0.2s ease-out;
}
</style>

@endsection