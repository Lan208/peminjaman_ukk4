@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
            <i class="fas fa-tags text-white text-2xl"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-white">
                Manajemen Kategori
            </h2>
            <p class="text-cyan-200 text-sm mt-1">
                Kelola kategori buku di perpustakaan
            </p>
        </div>
    </div>
</div>

{{-- FORM TAMBAH KATEGORI --}}
<div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
    <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
        <i class="fas fa-plus-circle text-cyan-300"></i>
        Tambah Kategori Baru
    </h3>
    
    <form action="/categories" method="POST" class="flex flex-col sm:flex-row gap-3">
        @csrf
        <div class="flex-1">
            <input type="text" 
                   name="nama" 
                   placeholder="Masukkan nama kategori..." 
                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition"
                   required>
        </div>
        <button class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-md flex items-center gap-2">
            <i class="fas fa-save"></i>
            Simpan
        </button>
    </form>
</div>

{{-- DAFTAR KATEGORI --}}
<div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl">
    <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
        <i class="fas fa-list text-cyan-300"></i>
        Daftar Kategori
        <span class="text-xs bg-cyan-500/30 text-cyan-200 px-2 py-1 rounded-full ml-2">
            {{ $categories->count() }} Kategori
        </span>
    </h3>

    @if($categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20">
                        <th class="text-left py-3 px-4 text-cyan-200 font-medium text-sm">No</th>
                        <th class="text-left py-3 px-4 text-cyan-200 font-medium text-sm">Nama Kategori</th>
                        <th class="text-left py-3 px-4 text-cyan-200 font-medium text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $c)
                    <tr class="border-b border-white/10 hover:bg-white/5 transition">
                        {{-- NOMOR --}}
                        <td class="py-3 px-4 text-white text-sm">{{ $index + 1 }}</td>
                        
                        {{-- FORM UPDATE --}}
                        <td class="py-3 px-4">
                            <form action="/categories/{{ $c->id }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="text" 
                                       name="nama" 
                                       value="{{ $c->nama }}" 
                                       class="px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400 w-full sm:w-64">
                                <button type="submit" 
                                        class="bg-green-500/80 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition text-sm flex items-center gap-1">
                                    <i class="fas fa-edit"></i>
                                    <span class="hidden sm:inline">Update</span>
                                </button>
                            </form>
                        </td>
                        
                        {{-- FORM DELETE --}}
                        <td class="py-3 px-4">
                            <form action="/categories/{{ $c->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $c->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500/80 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition text-sm flex items-center gap-1">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- KOSONG --}}
        <div class="text-center py-12">
            <i class="fas fa-folder-open text-5xl text-cyan-300/50 mb-3"></i>
            <p class="text-cyan-200">Belum ada kategori. Silakan tambah kategori baru.</p>
        </div>
    @endif
</div>

@endsection