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
                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded-full">{{ $books->count() }}
                        buku</span>
                </div>

                <button onclick="openModal('addModal')"
                    class="inline-flex items-center justify-center gap-1.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Buku
                </button>
            </div>

            <!-- TABLE AREA - tanpa scroll sama sekali -->
            <div class="flex-1 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden min-h-0">
                <div class="overflow-x-auto h-full">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/30">
                                <th
                                    class="px-3 py-3 sm:px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-14">
                                    No</th>
                                <th
                                    class="px-3 py-3 sm:px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Judul</th>
                                <th
                                    class="px-3 py-3 sm:px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Penulis</th>
                                <th
                                    class="px-3 py-3 sm:px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Penerbit</th>
                                <th
                                    class="px-3 py-3 sm:px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                    Tahun</th>
                                <th
                                    class="px-3 py-3 sm:px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                    Stok</th>
                                <th
                                    class="px-3 py-3 sm:px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                    Aksi</th>
                            </tr>

                            @foreach($books as $b)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="px-3 py-3 sm:px-4 text-gray-500 text-sm">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-3 sm:px-4 font-medium text-gray-800">{{ $b->judul }}</td>
                                    <td class="px-3 py-3 sm:px-4 text-gray-600 hidden sm:table-cell">{{ $b->penulis }}</td>
                                    <td class="px-3 py-3 sm:px-4 text-gray-600 hidden md:table-cell">{{ $b->penerbit }}</td>
                                    <td class="px-3 py-3 sm:px-4 text-gray-600">{{ $b->tahun_terbit }}</td>
                                    <td class="px-3 py-3 sm:px-4">
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            <span class="text-gray-700">{{ $b->stok }}</span>
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 sm:px-4">
                                        <div class="flex items-center gap-1.5 sm:gap-2">
                                            @if($b->stok > 0)
                                                <form action="/pinjam/{{ $b->id }}" method="POST" class="inline">
   
</form>
                                            @else
                                                <button disabled
                                                    class="bg-gray-300 text-white px-2 py-1 rounded text-xs cursor-not-allowed">
                                                    Stok Habis
                                                </button>
                                            @endif
                                            <button onclick="openModal('editModal{{ $b->id }}')"
                                                class="text-cyan-600 hover:text-cyan-700 bg-cyan-50 hover:bg-cyan-100 px-2 py-1 sm:px-2.5 rounded-md text-xs font-medium transition whitespace-nowrap">
                                                Edit
                                            </button>
                                           @php
    $loan = $loans[$b->id] ?? null;
@endphp

@if($loan && in_array($loan->status, ['approved', 'return_pending']))
    <button disabled class="bg-gray-400 text-white px-2 py-1 text-xs rounded">
        Sedang Dipinjam
    </button>
@else
    <button onclick="openModal('pinjamModal{{ $b->id }}')" 
        class="bg-green-500 text-white px-2 py-1 rounded text-xs">
        Pinjam
    </button>
@endif

@php
    $loan = $loans[$b->id] ?? null;
@endphp

@if($loan && $loan->status == 'approved')
    <form action="/return-request/{{ $loan->id }}" method="POST">
        @csrf
        <button class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">
            Kembalikan
        </button>
    </form>
@endif

@if($loan && $loan->status == 'return_pending')
    <span class="text-xs text-gray-500">Menunggu approval</span>
@endif

@if($loan && $loan->status == 'returned')
    <span class="text-xs text-green-600">Sudah dikembalikan</span>
@endif

                                            <form action="/books/{{ $b->id }}" method="POST" class="inline"
                                                onsubmit="return confirm('Yakin hapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-2 py-1 sm:px-2.5 rounded-md text-xs font-medium transition whitespace-nowrap">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <div id="pinjamModal{{ $b->id }}" 
    class="hidden fixed inset-0 z-50 bg-black/30 flex items-center justify-center">

    <div class="bg-white p-5 rounded-lg w-80">
        <h3 class="text-lg font-semibold mb-3">Pinjam Buku</h3>

        <form action="/pinjam/{{ $b->id }}" method="POST">
            @csrf

            <label class="text-sm">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="w-full border p-2 mb-2">

            <label class="text-sm">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="w-full border p-2 mb-2">

            <label class="text-sm">Jumlah</label>
            <input type="number" name="jumlah" min="1" max="{{ $b->stok }}" 
                class="w-full border p-2 mb-3">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('pinjamModal{{ $b->id }}')" 
                    class="px-3 py-1 bg-gray-300 rounded">
                    Batal
                </button>

                <button type="submit" 
                    class="px-3 py-1 bg-green-500 text-white rounded">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

                                <!-- MODAL EDIT -->
                                <div id="editModal{{ $b->id }}"
                                    class="hidden fixed inset-0 z-50 bg-black/30 flex items-center justify-center p-4"
                                    onclick="if(event.target===this) closeModal('editModal{{ $b->id }}')">
                                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
                                        <div class="flex justify-between items-center px-5 py-3 border-b border-gray-100">
                                            <h3 class="text-base font-medium text-gray-800">Edit Buku</h3>
                                            <button onclick="closeModal('editModal{{ $b->id }}')"
                                                class="text-gray-400 hover:text-gray-600 text-xl leading-5">&times;</button>
                                        </div>
                                        <form method="POST" action="/books/{{ $b->id }}" class="p-5 space-y-3">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label class="block text-xs text-gray-500 mb-1">Judul Buku</label>
                                                <input type="text" name="judul" value="{{ $b->judul }}"
                                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500 mb-1">Penulis</label>
                                                <input type="text" name="penulis" value="{{ $b->penulis }}"
                                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500 mb-1">Penerbit</label>
                                                <input type="text" name="penerbit" value="{{ $b->penerbit }}"
                                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs text-gray-500 mb-1">Tahun Terbit</label>
                                                    <input type="number" name="tahun_terbit" value="{{ $b->tahun_terbit }}"
                                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                                                </div>
                                                <div>
                                                    <label class="block text-xs text-gray-500 mb-1">Stok</label>
                                                    <input type="number" name="stok" value="{{ $b->stok }}"
                                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                                                </div>
                                            </div>
                                            <div class="flex justify-end gap-2 pt-2">
                                                <button type="button" onclick="closeModal('editModal{{ $b->id }}')"
                                                    class="px-3 py-1.5 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-1.5 text-sm bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg shadow-sm transition">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            @if($books->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center text-gray-400 text-sm">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        Belum ada data buku
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                    </table>
                    <!-- PESAN jika data terlalu banyak (tapi tetap ga bisa scroll) -->
                    @if($books->count() > 8)
                        <div class="absolute bottom-2 left-0 right-0 text-center text-xs text-amber-500 bg-white/90 py-1">
                            ⚡ Data melebihi tampilan, silakan scroll tabel untuk melihat lebih banyak
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer kecil -->
            <div class="mt-3 text-center text-xs text-gray-400 flex-shrink-0">
                <span>Total {{ $books->count() }} buku</span>
            </div>

        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div id="addModal" class="hidden fixed inset-0 z-50 bg-black/30 flex items-center justify-center p-4"
        onclick="if(event.target===this) closeModal('addModal')">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
            <div class="flex justify-between items-center px-5 py-3 border-b border-gray-100">
                <h3 class="text-base font-medium text-gray-800">Tambah Buku Baru</h3>
                <button onclick="closeModal('addModal')"
                    class="text-gray-400 hover:text-gray-600 text-xl leading-5">&times;</button>
            </div>
            <form method="POST" action="/books" class="p-5 space-y-3">
                @csrf
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Judul Buku</label>
                    <input type="text" name="judul" placeholder="Masukkan judul buku"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Penulis</label>
                    <input type="text" name="penulis" placeholder="Nama penulis"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Penerbit</label>
                    <input type="text" name="penerbit" placeholder="Nama penerbit"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" placeholder="2024"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Stok</label>
                        <input type="number" name="stok" placeholder="Jumlah stok"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-cyan-400 focus:ring-1 focus:ring-cyan-200 transition">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('addModal')"
                        class="px-3 py-1.5 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Batal</button>
                    <button type="submit"
                        class="px-4 py-1.5 text-sm bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg shadow-sm transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden')
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden')
        }

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                    }
                });
            }
        });

        // Mencegah scroll pada body saat modal terbuka
        document.addEventListener('wheel', function (e) {
            // Jika ada modal yang terbuka, tetap bisa scroll di dalam modal
            const modals = document.querySelectorAll('[id$="Modal"]:not(.hidden)');
            if (modals.length === 0) {
                // Jika tidak ada modal, cegah scroll di body
                const target = e.target;
                const isInTable = target.closest('.overflow-x-auto');
                if (!isInTable) {
                    e.preventDefault();
                }
            }
        }, { passive: false });
    </script>

    <style>
        /* Mencegah scroll pada body secara global */
        body {
            overflow: hidden;
        }

        /* Hanya area tabel yang bisa di-scroll horizontal */
        .overflow-x-auto {
            overflow-x: auto;
            overflow-y: hidden;
        }

        /* Hilangkan scrollbar yang tidak perlu */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

@endsection 