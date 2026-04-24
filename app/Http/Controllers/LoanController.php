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
    // ================= ADMIN APPROVE RETURN =================
    public function approveReturn(Request $request, $id)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'kondisi_buku' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
        ]);

        // Tarif denda per kondisi (sesuaikan sesukamu)
        $tarifKondisi = [
            'baik' => 0,
            'rusak_ringan' => 25000,
            'rusak_berat' => 75000,
            'hilang' => 150000,
        ];

        $loan = Loan::findOrFail($id);
        $book = Book::findOrFail($loan->book_id);

        // Hitung denda keterlambatan
        $tanggalKembaliRencana = \Carbon\Carbon::parse($loan->tanggal_kembali);
        $tanggalKembaliAktual = now();
        $hariTelat = max(0, $tanggalKembaliAktual->diffInDays($tanggalKembaliRencana, false) * -1);

        $tarifPerHari = 1000; // Rp 1.000/hari
        $dendaTelat = $hariTelat * $tarifPerHari;
        $dendaKerusakan = $tarifKondisi[$request->kondisi_buku];
        $dendaTotal = $dendaTelat + $dendaKerusakan;

        // Kembalikan stok (kecuali hilang — buku tidak kembali)
        if ($request->kondisi_buku !== 'hilang') {
            $book->increment('stok', $loan->jumlah);
        }

        $loan->update([
            'status' => 'returned',
            'tanggal_kembali' => $tanggalKembaliAktual,
            'kondisi_buku' => $request->kondisi_buku,   // ← kolom baru
            'denda_telat' => $dendaTelat,
            'denda_kerusakan' => $dendaKerusakan,
            'denda_total' => $dendaTotal,
        ]);

        $pesan = 'Pengembalian disetujui. Kondisi: ' . ucfirst(str_replace('_', ' ', $request->kondisi_buku)) . '.';
        if ($dendaTotal > 0) {
            $pesan .= ' Denda: Rp ' . number_format($dendaTotal, 0, ',', '.');
        }

        return back()->with('success', $pesan);
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

    public function riwayat()
    {
        $loans = Loan::where('user_id', auth()->id())
            ->with('book')
            ->latest()
            ->get();

        return view('loans.riwayat', compact('loans')); // pakai titik bukan slash
    }

}