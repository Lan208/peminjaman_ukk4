@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Halo, {{ Auth::user()->name }} 👋
</h2>

{{-- DASHBOARD ADMIN --}}
@auth
@if(auth()->user()->role == 'admin')
<div class="grid grid-cols-3 gap-6">
    <div class="bg-white p-5 rounded shadow">Total Buku</div>
    <div class="bg-white p-5 rounded shadow">Anggota</div>
    <div class="bg-white p-5 rounded shadow">Transaksi</div>
</div>
@endif
@endauth


{{-- DASHBOARD USER --}}
@auth
@if(auth()->user()->role != 'admin')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

    @foreach($books as $b)
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">

        {{-- TITLE --}}
        <h3 class="font-semibold text-gray-800 text-lg mb-1">
            {{ $b->judul }}
        </h3>

        <p class="text-xs text-gray-400 mb-3">
            Stok: {{ $b->stok }}
        </p>

        {{-- STATUS --}}
        @php $loan = $loans[$b->id] ?? null; @endphp

        <div class="flex justify-between items-center">

            @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded">
                    Dipinjam
                </span>
            @else
                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">
                    Tersedia
                </span>
            @endif

            {{-- BUTTON --}}
            @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                <button disabled class="bg-gray-400 text-white px-3 py-1 text-xs rounded">
                    Pinjam
                </button>
            @else
                <button onclick="openModal('pinjamModal{{ $b->id }}')" 
                    class="bg-cyan-500 hover:bg-cyan-600 text-white px-3 py-1 text-xs rounded">
                    Pinjam
                </button>
            @endif

        </div>

    </div>

    {{-- MODAL PINJAM --}}
    <div id="pinjamModal{{ $b->id }}" class="hidden fixed inset-0 bg-black/30 flex justify-center items-center">
        <div class="bg-white p-5 rounded-xl w-80 shadow-lg">

            <h3 class="font-semibold mb-3">Pinjam Buku</h3>

            <form action="/pinjam/{{ $b->id }}" method="POST">
                @csrf

                <label class="text-xs">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="w-full mb-2 border p-2 rounded">

                <label class="text-xs">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="w-full mb-2 border p-2 rounded">

                <label class="text-xs">Jumlah</label>
                <input type="number" name="jumlah" max="{{ $b->stok }}" class="w-full mb-3 border p-2 rounded">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('pinjamModal{{ $b->id }}')" class="text-gray-500">
                        Batal
                    </button>
                    <button class="bg-cyan-500 text-white px-3 py-1 rounded">
                        Kirim
                    </button>
                </div>
            </form>

        </div>
    </div>

    @endforeach

</div>

@endif
@endauth


<script>
function openModal(id){
    document.getElementById(id).classList.remove('hidden')
}
function closeModal(id){
    document.getElementById(id).classList.add('hidden')
}
</script>

@endsection