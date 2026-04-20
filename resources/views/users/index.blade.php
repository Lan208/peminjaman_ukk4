@extends('layouts.app')
@section('content')

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-700">👤 Data User</h2>

        <button onclick="openModal('addModal')" 
            class="bg-cyan-500 hover:bg-cyan-600 text-white px-5 py-2 rounded-xl shadow transition">
            + Tambah User
        </button>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-2xl shadow p-4">

        <table class="w-full text-sm text-gray-600">
            <thead>
                <tr class="border-b text-left text-gray-500">
                    <th class="p-3">No</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $u)
                <tr class="border-b hover:bg-cyan-50 transition">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3 font-medium text-gray-700">{{ $u->name }}</td>
                    <td class="p-3">{{ $u->email }}</td>

                    <td class="p-3">
                        <span class="bg-cyan-100 text-cyan-600 px-3 py-1 rounded-full text-xs">
                            {{ $u->role }}
                        </span>
                    </td>

                    <td class="p-3 flex gap-3">

                        <!-- EDIT -->
                        <button onclick="openModal('editModal{{ $u->id }}')" 
                            class="text-cyan-600 hover:underline">
                            Edit
                        </button>

                        <!-- DELETE -->
                        <form action="/users/{{ $u->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>

                <!-- MODAL EDIT -->
                <div id="editModal{{ $u->id }}" 
                    class="hidden fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">

                    <div class="bg-white p-6 rounded-2xl w-96 shadow-xl">

                        <h2 class="text-lg font-semibold mb-4 text-gray-700">Edit User</h2>

                        <form method="POST" action="/users/{{ $u->id }}">
                            @csrf
                            @method('PUT')

                            <input type="text" name="name" value="{{ $u->name }}" 
                                class="w-full mb-3 border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-cyan-400 outline-none">

                            <input type="email" name="email" value="{{ $u->email }}" 
                                class="w-full mb-3 border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-cyan-400 outline-none">

                            <input type="hidden" name="role" value="user">

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" onclick="closeModal('editModal{{ $u->id }}')" 
                                    class="bg-gray-300 px-4 py-1 rounded-lg text-white">
                                    Batal
                                </button>

                                <button class="bg-cyan-500 hover:bg-cyan-600 px-4 py-1 rounded-lg text-white">
                                    Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="addModal" 
    class="hidden fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">

    <div class="bg-white p-6 rounded-2xl w-96 shadow-xl">

        <h2 class="text-lg font-semibold mb-4 text-gray-700">Tambah User</h2>

        <form method="POST" action="/users">
            @csrf

            <input type="text" name="name" placeholder="Nama" 
                class="w-full mb-3 border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-cyan-400 outline-none">

            <input type="email" name="email" placeholder="Email" 
                class="w-full mb-3 border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-cyan-400 outline-none">

            <input type="password" name="password" placeholder="Password" 
                class="w-full mb-3 border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-cyan-400 outline-none">

            <input type="hidden" name="role" value="user">

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('addModal')" 
                    class="bg-gray-300 px-4 py-1 rounded-lg text-white">
                    Batal
                </button>

                <button class="bg-cyan-500 hover:bg-cyan-600 px-4 py-1 rounded-lg text-white">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<!-- JS -->
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>

@endsection