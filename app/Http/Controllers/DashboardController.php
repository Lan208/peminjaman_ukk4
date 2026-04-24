<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔹 DATA UNTUK USER (list buku)
        $books = Book::all();

        $loans = Loan::where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'return_pending'])
            ->get()
            ->keyBy('book_id');

        // 🔹 DATA UNTUK ADMIN (statistik)
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalLoans = Loan::count();
        $totalDipinjam = Loan::where('status', 'approved')->count();

        // 🔹 KIRIM SEMUA KE VIEW
        return view('dashboard', compact(
            'books',
            'loans',
            'totalBooks',
            'totalUsers',
            'totalLoans',
            'totalDipinjam'
        ));
    }
}