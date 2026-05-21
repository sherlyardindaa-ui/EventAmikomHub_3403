<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString(); // biar search tetap ada di pagination

        return view('admin.categories.index', compact('categories', 'search'));
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kategori
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mengupdate kategori
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Menghapus kategori
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}