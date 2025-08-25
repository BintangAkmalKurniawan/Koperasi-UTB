<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTabungan;
use App\Models\Tabungan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class TabunganController extends Controller
{
    public function index()
    {
        $anggotas = User::where('role', 'anggota')->get();
        foreach ($anggotas as $anggota) {
            Tabungan::firstOrCreate(['id_user' => $anggota->id_user]);
        }

        $tabunganData = Tabungan::with('user')->get();
        $totalSeluruhTabungan = $tabunganData->sum('total_tabungan');

        return view('Tabungan.index', compact('tabunganData', 'totalSeluruhTabungan'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'jumlah' => str_replace(['.', ','], '', $request->input('jumlah'))
        ]);

        $validated = $request->validate([
            'id_user' => 'required|string|exists:users,id_user',
            'jenis_transaksi' => 'required|in:menabung,menarik',
            'jumlah' => 'required|numeric|min:1000',
        ]);

        $tabungan = Tabungan::where('id_user', $validated['id_user'])->firstOrFail();

        DB::beginTransaction();
        try {
            if ($validated['jenis_transaksi'] == 'menabung') {
                $tabungan->total_tabungan += $validated['jumlah'];
            } 
            
            if ($validated['jenis_transaksi'] == 'menarik') {
                if ($validated['jumlah'] > $tabungan->total_tabungan) {
                    throw new \Exception('Saldo tidak mencukupi untuk melakukan penarikan.');
                }
                $tabungan->total_tabungan -= $validated['jumlah'];
            }

            $tabungan->save();

            RiwayatTabungan::create([
                'id_tabungan' => $tabungan->id_tabungan,
                'id_user' => $validated['id_user'],
                'jenis_transaksi' => $validated['jenis_transaksi'],
                'jumlah' => $validated['jumlah'],
                'tanggal_transaksi' => Carbon::now(),
            ]);

            DB::commit();
            return back()->with('success', 'Transaksi tabungan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal transaksi tabungan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cetakRekap($id_user)
    {
        $user = User::with(['tabungan', 'riwayatTabungan' => function ($q) {
            $q->orderBy('tanggal_transaksi', 'asc');
        }])->findOrFail($id_user);

        $pdf = Pdf::loadView('tabungan.rekap', compact('user'));
        return $pdf->stream('rekap_tabungan_'.$user->id_user.'.pdf');
    }
}
