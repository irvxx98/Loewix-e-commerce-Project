<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\ProdukImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function buildCategoryList($categories, $parentId = 0, $prefix = '')
    {
        $result = [];
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->nama_kategori = $prefix . $category->nama_kategori;
                $result[] = $category;
                $result = array_merge($result, $this->buildCategoryList($categories, $category->id, $prefix . '-- '));
            }
        }
        return $result;
    }

    public function index(Request $request)
    {
        $query = Produk::with('kategori')->latest();
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $produks = $query->paginate(10);
        return view('admin.products.index', compact('produks'));
    }

    public function create()
    {
        $categoriesByParent = Kategori::all()->groupBy('parent_id');
        return view('admin.products.create', compact('categoriesByParent'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'merk' => 'required|string|max:255',
            'berat' => 'required|integer|min:0',
            'diskon' => 'nullable|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
            'is_popular' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validated['is_popular'] = $request->has('is_popular');
        $product = Produk::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image' => $path]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $product)
    {
        $categoriesByParent = Kategori::all()->groupBy('parent_id');
        $selectedCategoryIds = [];
        $category = $product->kategori;
        while ($category) {
            array_unshift($selectedCategoryIds, $category->id);
            $category = $category->parent;
        }

        return view('admin.products.edit', [
            'product' => $product,
            'categoriesByParent' => $categoriesByParent,
            'selectedCategoryIds' => $selectedCategoryIds
        ]);
    }

    public function update(Request $request, Produk $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'merk' => 'required|string|max:255',
            'berat' => 'required|integer|min:0',
            'diskon' => 'nullable|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
            'is_popular' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validated['is_popular'] = $request->has('is_popular');
        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image' => $path]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyImage(ProdukImage $image)
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function destroy(Produk $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
