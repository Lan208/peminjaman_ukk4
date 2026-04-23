@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Kategori</h2>

<form action="/categories" method="POST" class="mb-4">
    @csrf
    <input type="text" name="nama" placeholder="Nama kategori" class="border p-2">
    <button class="bg-blue-500 text-white px-3 py-1">Tambah</button>
</form>

@foreach($categories as $c)
<div class="flex gap-2 mb-2">

    <form action="/categories/{{ $c->id }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="nama" value="{{ $c->nama }}" class="border p-1">
        <button class="bg-green-500 text-white px-2">Update</button>
    </form>

    <form action="/categories/{{ $c->id }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="bg-red-500 text-white px-2">Hapus</button>
    </form>

</div>
@endforeach

@endsection