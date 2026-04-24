<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;


class AuthController extends Controller
{
    // TAMPILAN LOGIN
    public function loginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        // ✅ VALIDASI INPUT
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // AMBIL DATA
        $credentials = $request->only('email', 'password');

        // CEK LOGIN
        if (Auth::attempt($credentials)) {

            // ✅ REGENERATE SESSION (biar aman)
            $request->session()->regenerate();

            // CEK ROLE
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard')->with('success', 'Login admin berhasil!');
            } else {
                return redirect('/dashboard')->with('success', 'Login user berhasil!');
            }
        }

        // KALAU GAGAL
        return back()->with('error', 'Email atau password salah!');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        // HAPUS SESSION
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout!');
    }
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalLoans = Loan::count();
        $totalDipinjam = Loan::where('status', 'approved')->count();

        return view('dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalLoans',
            'totalDipinjam'
        ));
    }
}
