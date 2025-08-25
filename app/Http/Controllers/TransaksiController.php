<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use App\Models\Product;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'detailTransaksis.produk.anggota'])->latest('created_at')->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $users = User::where('role', 'anggota')->orderBy('nama')->get();
        $Product = Product::where('stock', '>', 0)->with('images')->get();
        return view('transaksi.create', compact('users', 'Product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id_user', 
            'produk' => 'required|array|min:1',
            'produk.*.id_product' => 'required|exists:products,id_product',
            'produk.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                
                $totalHarga = 0;
                $detailProdukUntukDisimpan = [];

                foreach ($validated['produk'] as $item) {
                    $product = Product::lockForUpdate()->find($item['id_product']);

                    if (!$product || $product->stock < $item['jumlah']) {
                        throw ValidationException::withMessages([
                            'produk' => 'Stok untuk produk "' . ($product->name ?? 'N/A') . '" tidak mencukupi.'
                        ]);
                    }
                    
                    $hargaSatuan = $product->price;
                    $subtotal = $item['jumlah'] * $hargaSatuan;
                    $totalHarga += $subtotal;
                    $idPenjual = $product->id_user;

                    $saldoTerakhir = DetailTransaksi::where('id_user', $idPenjual)
                                                ->latest('created_at') 
                                                ->value('saldo');      

                    $saldoBaru = ($saldoTerakhir ?? 0) + $subtotal;

                    $detailProdukUntukDisimpan[] = [
                        'id_product'   => $item['id_product'],
                        'jumlah'       => $item['jumlah'],
                        'harga_satuan' => $hargaSatuan,
                        'subtotal'     => $subtotal,
                        'id_user'      => $idPenjual,
                        'saldo'        => $saldoBaru,
                    ];
                }

                $transaksi = Transaksi::create([
                    'id_user'           => $validated['id_user'], 
                    'total_harga'       => $totalHarga,
                    'tanggal_transaksi' => now(), 
                ]);

                foreach ($detailProdukUntukDisimpan as $detail) {
                    $transaksi->detailTransaksis()->create($detail);
                    Product::find($detail['id_product'])->decrement('stock', $detail['jumlah']);
                }

                return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
            });

        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan transaksi: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan transaksi.');
        }
    }

    public function edit(Transaksi $transaksi)
    {
        $users = User::all();
        $produks = Product::all();
        $transaksi->load('detailTransaksis.produk');
        return view('transaksi.edit', compact('transaksi', 'users', 'produks'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        return redirect()->route('transaksi.index')->with('info', 'Fungsi update belum diimplementasikan sepenuhnya.');
    }

    public function destroy(Transaksi $transaksi)
    {
        try {
            DB::transaction(function () use ($transaksi) {
                foreach($transaksi->detailTransaksis as $detail) {
                    $product = Product::find($detail->id_product);
                    if ($product) {
                        $product->increment('stock', $detail->jumlah);
                    }
                }

                $transaksi->detailTransaksis()->delete();
                $transaksi->delete();
            });

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus transaksi: ' . $e->getMessage());
            return redirect()->route('transaksi.index')->with('error', 'Gagal menghapus transaksi.');
        }
    }

    public function cetakStruk(Transaksi $transaksi)
    {
        $transaksi->load('user', 'detailTransaksis.produk');

        $pdf = Pdf::loadView('transaksi.struk', compact('transaksi'));
        return $pdf->stream('struk_'.$transaksi->id.'.pdf');
    }
}
