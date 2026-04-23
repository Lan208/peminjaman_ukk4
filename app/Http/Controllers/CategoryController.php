<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        Category::create($request->all());
        return back();
    }

    public function update(Request $request, $id)
    {
        Category::findOrFail($id)->update($request->all());
        return back();
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return back();
    }
}