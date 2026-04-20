<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // TAMPILKAN DATA
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('users.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // 🔒 dipaksa user
        ]);
        return redirect('/users')->with('success', 'User berhasil ditambahkan!');
    }

    // FORM EDIT
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        return redirect('/users')->with('success', 'User berhasil diupdate!');
    }

    // DELETE
    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus!');
    }
}