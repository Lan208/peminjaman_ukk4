<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // USER LIHAT DATA
    public function index()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loans = Loan::with('user', 'book')->get();
        return view('loans.index', compact('loans'));
    }

    // USER PINJAM
    public function store(Request $request, $book_id)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1'
        ]);

        $book = Book::findOrFail($book_id);

        if ($request->jumlah > $book->stok) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Menunggu approval admin');
    }

    public function approve($id)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loan = Loan::findOrFail($id);
        $book = Book::findOrFail($loan->book_id);

        if ($loan->jumlah > $book->stok) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $book->decrement('stok', $loan->jumlah);

        $loan->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Disetujui');
    }

    public function reject($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update(['status' => 'rejected']);

        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        return back()->with('success', 'Ditolak');
    }
    public function history()
    {
        $loans = Loan::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('loans.history', compact('loans'));
    }
    public function requestReturn($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->user_id != Auth::id()) {
            abort(403);
        }

        if ($loan->status != 'approved') {
            return back()->with('error', 'Tidak bisa dikembalikan');
        }

        $loan->update([
            'status' => 'return_pending'
        ]);

        return back()->with('success', 'Menunggu approval pengembalian');
    }
    public function approveReturn($id)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loan = Loan::findOrFail($id);
        $book = Book::findOrFail($loan->book_id);

        $book->increment('stok', $loan->jumlah);

        $loan->update([
            'status' => 'returned',
            'tanggal_kembali' => now()
        ]);

        return back()->with('success', 'Pengembalian disetujui');
    }
    public function returnRequests()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loans = Loan::with('user', 'book')
            ->where('status', 'return_pending')
            ->get();

        return view('loans.return', compact('loans'));
    }

    public function myLoans()
    {
        $loans = Loan::where('user_id', Auth::id())->get();
        return view('loans.my', compact('loans'));
    }

    public function returnIndex()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loans = Loan::where('status_return', 'pending')->get();
        return view('loans.return', compact('loans'));
    }
}