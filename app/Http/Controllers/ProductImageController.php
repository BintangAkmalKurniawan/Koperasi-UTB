<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
public function destroy(Product $product, ProductImage $image)
{
    if ($image->id_product !== $product->id_product) {
        abort(403, 'Akses tidak valid');
    }

    if ($image->path && Storage::disk('public')->exists($image->path)) {
        Storage::disk('public')->delete($image->path);
    }

    if ($product->thumbnail_id === $image->id_product) {
        $product->update(['thumbnail_id' => null]);
    }

    $image->delete();

    return response()->json([
        'success' => true,
        'message' => 'Gambar berhasil dihapus'
    ]);
}
    public function setThumbnail(Product $product, ProductImage $image)
    {
        if ($image->id_product !== $product->id_product) {
            abort(403, 'Akses tidak valid');
        }

        $product->update(['thumbnail_id' => $image->id_product]);
        return back()->with('success', 'Gambar utama berhasil diubah');
    }
}
