<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::all();

        $loans = Loan::where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'return_pending'])
            ->get()
            ->keyBy('book_id');

        return view('dashboard', compact('books', 'loans'));
    }
}