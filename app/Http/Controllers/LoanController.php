<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // ================= ADMIN LIHAT SEMUA PEMINJAMAN =================
    public function index()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loans = Loan::with('user', 'book')->latest()->get();
        return view('loans.index', compact('loans'));
    }

    // ================= USER PINJAM =================
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
            'status' => 'pending' // ✅ FIX
        ]);

        return back()->with('success', 'Menunggu approval admin');
    }

    // ================= ADMIN APPROVE PINJAM =================
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

    // ================= ADMIN REJECT =================
    public function reject($id)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loan = Loan::findOrFail($id);
        $loan->update(['status' => 'rejected']);

        return back()->with('success', 'Ditolak');
    }

    // ================= USER HISTORY =================
    public function history()
    {
        $loans = Loan::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('loans.history', compact('loans'));
    }

    // ================= USER REQUEST RETURN =================
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
            'status' => 'return_pending' // ✅ FIX
        ]);

        return back()->with('success', 'Menunggu approval pengembalian');
    }

    // ================= ADMIN APPROVE RETURN =================
    public function approveReturn($id)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loan = Loan::findOrFail($id);
        $book = Book::findOrFail($loan->book_id);

        // kembalikan stok
        $book->increment('stok', $loan->jumlah);

        $loan->update([
            'status' => 'returned', // ✅ FIX
            'tanggal_kembali' => now()
        ]);

        return back()->with('success', 'Pengembalian disetujui');
    }

    // ================= ADMIN LIHAT REQUEST RETURN =================
    public function returnIndex()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $loans = Loan::with('user', 'book')
            ->where('status', 'return_pending') // ✅ FIX
            ->get();

        return view('loans.return', compact('loans'));
    }

    // ================= USER LIHAT PINJAMAN SENDIRI =================
    public function myLoans()
    {
        $loans = Loan::with('book')
            ->where('user_id', Auth::id())
            ->get();

        return view('loans.my', compact('loans'));
    }
}