@extends('layouts.app')

@section('content')
<div class="p-6">

    <h2 class="text-xl font-bold mb-4">Approval Pengembalian</h2>

    <table class="w-full border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">User</th>
                <th class="p-2">Buku</th>
                <th class="p-2">Jumlah</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($loans as $loan)
            <tr class="border">
                <td class="p-2">{{ $loan->user->name }}</td>
                <td class="p-2">{{ $loan->book->judul }}</td>
                <td class="p-2">{{ $loan->jumlah }}</td>
                <td class="p-2">

                    <form action="/approve-return/{{ $loan->id }}" method="POST">
                        @csrf
                        <button class="bg-green-500 text-white px-3 py-1 rounded">
                            Approve
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection