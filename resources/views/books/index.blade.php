@extends('layouts.app')
@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">
                        Data Buku
                    </h2>
                    <p class="text-cyan-200 text-sm mt-1">
                        Kelola koleksi buku perpustakaan
                    </p>
                </div>
                <span class="bg-cyan-500/30 text-cyan-200 px-3 py-1 rounded-full text-sm ml-2">
                    {{ $books->count() }} Buku
                </span>
            </div>

            @auth
                @if(auth()->user()->role == 'admin')
                    <button onclick="openModal('addModal')"
                        class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2.5 rounded-xl shadow-md transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Buku
                    </button>
                @endif
            @endauth
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">No</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Judul</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Kategori</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Penulis</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Penerbit</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Tahun</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Gambar</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Stok</th>
                        <th class="px-4 py-3 text-left text-cyan-200 font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $b)
                        <tr class="border-b border-white/10 hover:bg-white/5 transition-all duration-200">
                            <td class="px-4 py-3 text-white">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-white">{{ $b->judul }}</td>
                            <td class="px-4 py-3">
                                <span class="bg-cyan-500/20 text-cyan-200 px-2 py-1 rounded-full text-xs">
                                    {{ $b->category->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-cyan-200">{{ $b->penulis }}</td>
                            <td class="px-4 py-3 text-cyan-200">{{ $b->penerbit }}</td>
                            <td class="px-4 py-3 text-cyan-200">{{ $b->tahun_terbit }}</td>
                            <td class="px-4 py-3">
                                @if($b->image)
                                    <img src="{{ asset('images/' . $b->image) }}" class="w-12 h-12 object-cover rounded-lg shadow">
                                @else
                                    <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-cyan-300/50"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="bg-green-500/20 text-green-200 px-2 py-1 rounded-full text-xs">
                                    {{ $b->stok }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2 flex-wrap">
                                    
                                    {{-- USER ONLY (PINJAM & KEMBALIKAN) --}}
                                    @auth
                                        @if(auth()->user()->role != 'admin')
                                            @php $loan = $loans[$b->id] ?? null; @endphp

                                            @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                                                <button disabled class="bg-gray-500/50 text-white/70 px-3 py-1.5 text-xs rounded-xl cursor-not-allowed flex items-center gap-1">
                                                    <i class="fas fa-clock"></i> Dipinjam
                                                </button>
                                            @else
                                                <button onclick="openPinjamModal({{ $b->id }}, {{ $b->stok }})"
                                                    class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-3 py-1.5 text-xs rounded-xl transition flex items-center gap-1">
                                                    <i class="fas fa-hand-holding-heart"></i> Pinjam
                                                </button>
                                            @endif

                                            @if($loan && $loan->status == 'approved')
                                                <form action="/return-request/{{ $loan->id }}" method="POST">
                                                    @csrf
                                                    <button class="bg-yellow-500/80 hover:bg-yellow-600 text-white px-3 py-1.5 text-xs rounded-xl transition flex items-center gap-1">
                                                        <i class="fas fa-undo-alt"></i> Kembali
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @endauth

                                    {{-- ADMIN ONLY --}}
                                    @auth
                                        @if(auth()->user()->role == 'admin')
                                            <button onclick="openEditModal({{ $b->id }})"
                                                class="bg-cyan-500/80 hover:bg-cyan-600 text-white px-3 py-1.5 text-xs rounded-xl transition flex items-center gap-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <form action="/books/{{ $b->id }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus buku {{ $b->judul }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500/80 hover:bg-red-600 text-white px-3 py-1.5 text-xs rounded-xl transition flex items-center gap-1">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- KOSONG --}}
        @if($books->count() == 0)
        <div class="text-center py-12">
            <i class="fas fa-book-open text-5xl text-cyan-300/50 mb-3"></i>
            <p class="text-cyan-200">Belum ada buku. Silakan tambah buku baru.</p>
        </div>
        @endif

    </div>
</div>

{{-- ==================== MODAL PINJAM (1 MODAL SAJA) ==================== --}}
@auth
    @if(auth()->user()->role != 'admin')
        <div id="pinjamModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
            <div class="bg-gradient-to-br from-white to-cyan-50 rounded-2xl w-96 shadow-2xl animate-fade-in">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4 border-b border-cyan-200 pb-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hand-holding-heart text-white"></i>
                        </div>
                        <h2 class="font-bold text-cyan-800 text-lg">Pinjam Buku</h2>
                    </div>

                    <form id="pinjamForm" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="text-xs text-cyan-700 font-medium block mb-1">
                                <i class="fas fa-calendar-alt mr-1"></i> Tanggal Pinjam
                            </label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        </div>

                        <div class="mb-4">
                            <label class="text-xs text-cyan-700 font-medium block mb-1">
                                <i class="fas fa-calendar-check mr-1"></i> Tanggal Kembali
                            </label>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                                class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        </div>

                        <div class="mb-5">
                            <label class="text-xs text-cyan-700 font-medium block mb-1">
                                <i class="fas fa-sort-amount-up mr-1"></i> Jumlah (Maks: <span id="maxStok"></span>)
                            </label>
                            <input type="number" name="jumlah" id="jumlah" max="" value="1"
                                class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeModal('pinjamModal')"
                                class="text-gray-500 hover:text-gray-700 px-4 py-2 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2 rounded-xl transition shadow-md">
                                <i class="fas fa-paper-plane mr-1"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth

{{-- ==================== MODAL EDIT (1 MODAL SAJA) ==================== --}}
@auth
    @if(auth()->user()->role == 'admin')
        <div id="editModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
            <div class="bg-gradient-to-br from-white to-cyan-50 rounded-2xl w-[500px] max-w-[90vw] shadow-2xl animate-fade-in">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4 border-b border-cyan-200 pb-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <h2 class="font-bold text-cyan-800 text-lg">Edit Buku</h2>
                    </div>

                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="sm:col-span-2">
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Judul</label>
                                <input type="text" name="judul" id="edit_judul"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Kategori</label>
                                <select name="category_id" id="edit_category_id" class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Penulis</label>
                                <input type="text" name="penulis" id="edit_penulis"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Penerbit</label>
                                <input type="text" name="penerbit" id="edit_penerbit"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" id="edit_tahun_terbit"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Stok</label>
                                <input type="number" name="stok" id="edit_stok"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Gambar</label>
                                <input type="file" name="image" id="edit_image"
                                    class="w-full border border-cyan-200 rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                <p id="currentImage" class="text-xs text-cyan-500 mt-1"></p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-5">
                            <button type="button" onclick="closeModal('editModal')"
                                class="text-gray-500 hover:text-gray-700 px-4 py-2 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2 rounded-xl transition shadow-md">
                                <i class="fas fa-save mr-1"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth

{{-- MODAL TAMBAH --}}
@auth
    @if(auth()->user()->role == 'admin')
        <div id="addModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
            <div class="bg-gradient-to-br from-white to-cyan-50 rounded-2xl w-[500px] max-w-[90vw] shadow-2xl animate-fade-in">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4 border-b border-cyan-200 pb-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-plus-circle text-white"></i>
                        </div>
                        <h2 class="font-bold text-cyan-800 text-lg">Tambah Buku</h2>
                    </div>

                    <form method="POST" action="/books" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="sm:col-span-2">
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Judul</label>
                                <input type="text" name="judul" placeholder="Masukkan judul buku"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Kategori</label>
                                <select name="category_id" class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Penulis</label>
                                <input type="text" name="penulis" placeholder="Nama penulis"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Penerbit</label>
                                <input type="text" name="penerbit" placeholder="Nama penerbit"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" placeholder="Tahun"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Stok</label>
                                <input type="number" name="stok" placeholder="Jumlah stok"
                                    class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-xs text-cyan-700 font-medium block mb-1">Gambar</label>
                                <input type="file" name="image" 
                                    class="w-full border border-cyan-200 rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-5">
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
    @endif
@endauth

<script>
    // Data buku dari server
    const booksData = @json($books->keyBy('id'));
    const categoriesData = @json($categories);

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Buka modal pinjam dengan data dinamis
    function openPinjamModal(bookId, stok) {
        const form = document.getElementById('pinjamForm');
        form.action = '/pinjam/' + bookId;
        document.getElementById('maxStok').innerText = stok;
        document.getElementById('jumlah').max = stok;
        document.getElementById('jumlah').value = 1;
        
        // Set default tanggal
        const today = new Date().toISOString().split('T')[0];
        const nextWeek = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
        document.getElementById('tanggal_pinjam').value = today;
        document.getElementById('tanggal_kembali').value = nextWeek;
        
        openModal('pinjamModal');
    }

    // Buka modal edit dengan data dinamis
    function openEditModal(bookId) {
        const book = booksData[bookId];
        if (!book) return;
        
        const form = document.getElementById('editForm');
        form.action = '/books/' + bookId;
        
        document.getElementById('edit_judul').value = book.judul || '';
        document.getElementById('edit_penulis').value = book.penulis || '';
        document.getElementById('edit_penerbit').value = book.penerbit || '';
        document.getElementById('edit_tahun_terbit').value = book.tahun_terbit || '';
        document.getElementById('edit_stok').value = book.stok || '';
        document.getElementById('edit_category_id').value = book.category_id || '';
        
        if (book.image) {
            document.getElementById('currentImage').innerHTML = 'Gambar saat ini: ' + book.image;
        } else {
            document.getElementById('currentImage').innerHTML = '';
        }
        
        openModal('editModal');
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