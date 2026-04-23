@extends('layouts.app')
@section('content')

    <div class="h-screen bg-gray-50 overflow-hidden">
        <div class="h-full flex flex-col p-4 sm:p-6 overflow-hidden">

            <!-- HEADER -->
            <div
                class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4 pb-3 border-b border-gray-100 flex-shrink-0">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-6 bg-cyan-400 rounded-full"></div>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Data Buku</h2>
                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded-full">
                        {{ $books->count() }} buku
                    </span>
                </div>

                @auth
                    @if(auth()->user()->role == 'admin')
                        <button onclick="openModal('addModal')"
                            class="inline-flex items-center justify-center gap-1.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm shadow-sm">
                            Tambah Buku
                        </button>
                    @endif
                @endauth
            </div>

            <!-- TABLE -->
            <div class="flex-1 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto h-full">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50/30">
                                <th class="px-3 py-3 text-left text-xs text-gray-500">No</th>
                                <th class="px-3 py-3 text-left text-xs text-gray-500">Judul</th>
                                <th class="px-3 py-3 text-left text-xs text-gray-500">Kategori</th>
                                <th class="px-3 py-3 text-left text-xs text-gray-500">Penulis</th>
                                <th class="px-3 py-3 text-left text-xs text-gray-500">Penerbit</th>
                                <th class="px-3 py-3 text-left text-xs text-gray-500">Tahun</th>
                                <th class="px-3 py-3 text-left text-xs text-gray-500">Stok</th>
                                <th class="px-3 py-3 text-left text-xs text-gray-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($books as $b)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-2">{{ $b->judul }}</td>
                                    <td class="px-3 py-2">
                                        {{ $b->category->nama ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2">{{ $b->penulis }}</td>
                                    <td class="px-3 py-2">{{ $b->penerbit }}</td>
                                    <td class="px-3 py-2">{{ $b->tahun_terbit }}</td>
                                    <td class="px-3 py-2">{{ $b->stok }}</td>

                                    <td class="px-3 py-2 flex gap-2 flex-wrap">

                                        {{-- USER ONLY (PINJAM & KEMBALIKAN) --}}
                                        @auth
                                            @if(auth()->user()->role != 'admin')

                                                @php $loan = $loans[$b->id] ?? null; @endphp

                                                {{-- PINJAM --}}
                                                @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                                                    <button disabled class="bg-gray-400 text-white px-2 py-1 text-xs rounded">
                                                        Dipinjam
                                                    </button>
                                                @else
                                                    <button onclick="openModal('pinjamModal{{ $b->id }}')"
                                                        class="bg-green-500 text-white px-2 py-1 text-xs rounded">
                                                        Pinjam
                                                    </button>
                                                @endif

                                                {{-- KEMBALIKAN --}}
                                                @if($loan && $loan->status == 'approved')
                                                    <form action="/return-request/{{ $loan->id }}" method="POST">
                                                        @csrf
                                                        <button class="bg-yellow-500 text-white px-2 py-1 text-xs rounded">
                                                            Kembalikan
                                                        </button>
                                                    </form>
                                                @endif

                                            @endif
                                        @endauth

                                        {{-- ADMIN ONLY --}}
                                        @auth
                                            @if(auth()->user()->role == 'admin')

                                                <button onclick="openModal('editModal{{ $b->id }}')"
                                                    class="bg-cyan-500 text-white px-2 py-1 text-xs rounded">
                                                    Edit
                                                </button>

                                                <form action="/books/{{ $b->id }}" method="POST"
                                                    onsubmit="return confirm('Yakin hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="bg-red-500 text-white px-2 py-1 text-xs rounded">
                                                        Hapus
                                                    </button>
                                                </form>

                                            @endif
                                        @endauth

                                    </td>
                                </tr>

                                {{-- MODAL PINJAM (USER ONLY) --}}
                                @auth
                                    @if(auth()->user()->role != 'admin')
                                        <div id="pinjamModal{{ $b->id }}"
                                            class="hidden fixed inset-0 bg-black/30 flex justify-center items-center">
                                            <div class="bg-white p-4 rounded w-80">
                                                <form action="/pinjam/{{ $b->id }}" method="POST">
                                                    @csrf
                                                    <input type="date" name="tanggal_pinjam" class="w-full mb-2 border p-2">
                                                    <input type="date" name="tanggal_kembali" class="w-full mb-2 border p-2">
                                                    <input type="number" name="jumlah" max="{{ $b->stok }}"
                                                        class="w-full mb-2 border p-2">

                                                    <div class="flex justify-end gap-2">
                                                        <button type="button"
                                                            onclick="closeModal('pinjamModal{{ $b->id }}')">Batal</button>
                                                        <button class="bg-green-500 text-white px-3 py-1 rounded">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endauth

                                {{-- MODAL EDIT (ADMIN ONLY) --}}
                                @auth
                                    @if(auth()->user()->role == 'admin')
                                        <div id="editModal{{ $b->id }}"
                                            class="hidden fixed inset-0 bg-black/30 flex justify-center items-center">
                                            <div class="bg-white p-4 rounded w-80">
                                                <form method="POST" action="/books/{{ $b->id }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="text" name="judul" value="{{ $b->judul }}"
                                                        class="w-full mb-2 border p-2">

                                                    {{-- KATEGORI --}}
                                                    <select name="category_id" class="w-full mb-2 border p-2">
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach($categories as $c)
                                                            <option value="{{ $c->id }}" {{ $b->category_id == $c->id ? 'selected' : '' }}>
                                                                {{ $c->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <input type="text" name="penulis" value="{{ $b->penulis }}"
                                                        class="w-full mb-2 border p-2">
                                                    <input type="text" name="penerbit" value="{{ $b->penerbit }}"
                                                        class="w-full mb-2 border p-2">
                                                    <input type="number" name="tahun_terbit" value="{{ $b->tahun_terbit }}"
                                                        class="w-full mb-2 border p-2">
                                                    <input type="number" name="stok" value="{{ $b->stok }}"
                                                        class="w-full mb-2 border p-2">

                                                    <div class="flex justify-end gap-2">
                                                        <button type="button"
                                                            onclick="closeModal('editModal{{ $b->id }}')">Batal</button>
                                                        <button class="bg-blue-500 text-white px-3 py-1 rounded">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endauth

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL TAMBAH (ADMIN ONLY) --}}
    @auth
        @if(auth()->user()->role == 'admin')
            <div id="addModal" class="hidden fixed inset-0 bg-black/30 flex justify-center items-center">
                <div class="bg-white p-4 rounded w-80">
                    <form method="POST" action="/books">
                        @csrf
                        <input type="text" name="judul" placeholder="Judul" class="w-full mb-2 border p-2">
                        <input type="text" name="penulis" placeholder="Penulis" class="w-full mb-2 border p-2">
                        <input type="text" name="penerbit" placeholder="Penerbit" class="w-full mb-2 border p-2">
                        <input type="number" name="tahun_terbit" placeholder="Tahun" class="w-full mb-2 border p-2">
                        <input type="number" name="stok" placeholder="Stok" class="w-full mb-2 border p-2">
                        <select name="category_id" class="w-full mb-2 border p-2">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                            @endforeach
                        </select>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeModal('addModal')">Batal</button>
                            <button class="bg-blue-500 text-white px-3 py-1 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden')
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden')
        }
    </script>

@endsection