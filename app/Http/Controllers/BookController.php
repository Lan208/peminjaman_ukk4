<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with('category')->get();
        $categories = Category::all();

        $loans = Loan::where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'return_pending'])
            ->get()
            ->keyBy('book_id');

        return view('books.index', compact('books', 'loans', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'stok' => 'required|integer'
        ]);

        Book::create($request->all());

        return back()->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $book->update($request->all());

        return back()->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return back()->with('success', 'Buku berhasil dihapus!');
    }

    
}