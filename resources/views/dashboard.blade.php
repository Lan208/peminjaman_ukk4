@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Halo, {{ Auth::user()->name }} 👋
</h2>

<div class="grid grid-cols-3 gap-6">
    <div class="bg-white p-5 rounded shadow">Total Buku</div>
    <div class="bg-white p-5 rounded shadow">Anggota</div>
    <div class="bg-white p-5 rounded shadow">Transaksi</div>
</div>

@endsection