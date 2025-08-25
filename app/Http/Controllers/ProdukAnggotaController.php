<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProdukAnggotaController extends Controller
{
    
    public function index(Request $request)
    {
        $category = $request->query('category');
        $query = Product::with('thumbnail');

        if ($category) {
            $query->where('category', $category);
        }

        $products = $query->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:250',
            'stock' => 'required|integer',
            'category'=> 'required | in:pertanian,sarana,UMKM',
            'id_user' => 'required|exists:users,id_user',
            'images.*' => 'nullable|image',
        ]);

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('products', 'public');
                $img = $product->images()->create(['path' => $path]); 

                if ($key === 0) {
                    $product->update(['thumbnail_id' => $img->id]);
                }
            }
        }
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }
    // Detail produk
    public function show(Product $product)
    {
        $product->load('images', 'thumbnail');
        return view('products.show', compact('product'));
    }

    // Form edit produk
    public function edit(Product $product)
    {
        $product->load('images', 'thumbnail');
        return view('products.edit', compact('product'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category'=> 'required | in:pertanian,sarana,UMKM',
            'id_user' => 'required|exists:users,id_user',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');

                $product->images()->create([
                    'path' => $path
                ]);
            }
        }
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk dipindahkan ke Trash');
    }
    public function trash()
    {
        $products = Product::onlyTrashed()->get();
        return view('products.trash', compact('products'));
    }
    public function restore($id_product)
    {
        $product = Product::onlyTrashed()->findOrFail($id_product);
        $product->restore();
        return redirect()->route('products.trash')->with('success', 'Produk berhasil dipulihkan');
    }
    public function forceDelete($id_product)
    {
        $product = Product::onlyTrashed()->findOrFail($id_product);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path); 
        }
        $product->forceDelete();
        return redirect()->route('products.trash')->with('success', 'Produk dihapus permanen');
    }
    public function autoDeleteOld()
    {
        $expired = Product::onlyTrashed()
            ->where('deleted_at', '<', Carbon::now()->subMinutes(1))
            ->get();
        foreach ($expired as $product) {
            $product->forceDelete();
        }
    }


public function indexAnggota(Request $request)
{
    $selectedCategory = $request->query('category');
    $userId = Auth::id();

    // Produk semua anggota (boleh difilter kategori)
    $products = Product::with(['thumbnail', 'images'])
        ->when($selectedCategory, function ($query, $selectedCategory) {
            return $query->where('category', $selectedCategory);
        })
        ->get();

    // Produk pribadi (TANPA filter kategori, hanya produk milik user)
    $productSendiri = Product::with('thumbnail')
        ->where('id_user', $userId)
        ->latest()
        ->get();

    // Kategori unik (bisa ambil dari database kalau mau dinamis)
    $categories = ['pertanian', 'sarana', 'UMKM'];

    return view('layoutanggota.produkAnggota.produk-anggota', compact(
        'products',
        'productSendiri',
        'categories',
        'selectedCategory'
    ));
}

public function indexAnggotaPribadi() 
{
    $userId = Auth::id();
    $products = Product::with('thumbnail')
                       ->where('id_user', $userId)
                       ->latest()
                       ->get();

    return view('layoutanggota.produkAnggota.produk', compact('products'));
}

    public function showAnggota($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        return view('layoutanggota.produkAnggota.detail-produk-anggota', compact('product'));
    }

}