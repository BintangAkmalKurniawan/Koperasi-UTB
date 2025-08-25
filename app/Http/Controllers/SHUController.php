<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\ShuDistribution;
use App\Models\ShuPeriod;
use App\Models\Simpanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class SHUController extends Controller
{
    public function index()
    {
        $periods = ShuPeriod::orderBy('periode', 'desc')->get();
        return view('SHU.list-shu', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode' => 'required|digits:4|integer|min:2020|unique:shu_periods,periode',
            'total_shu' => 'required|numeric|min:0',
            'persen_jasa_modal' => 'required|numeric|min:0|max:100',
            'persen_jasa_usaha' => 'required|numeric|min:0|max:100',
        ]);

        if (($validated['persen_jasa_modal'] + $validated['persen_jasa_usaha']) > 100) {
            return back()->with('error', 'Total persentase Jasa Modal dan Jasa Usaha tidak boleh melebihi 100%.');
        }

        DB::beginTransaction();
        try {
            // Hindari NULL: pakai COALESCE
            $totalSimpananKoperasi = Simpanan::sum(
                DB::raw('COALESCE(total_pokok,0) + COALESCE(total_wajib,0)')
            );

            // Ambil SALDO TERAKHIR per user (berdasarkan id terbesar per id_user), lalu jumlahkan
            $latestPerUser = DetailTransaksi::select('id_user', DB::raw('MAX(id) AS last_id'))
                ->groupBy('id_user');

            $lastSaldoRows = DetailTransaksi::joinSub($latestPerUser, 'last', function ($join) {
                    $join->on('detail_transaksis.id_user', '=', 'last.id_user')
                         ->on('detail_transaksis.id', '=', 'last.last_id');
                })
                ->get(['detail_transaksis.id_user', 'detail_transaksis.saldo']);

            $totalPenjualanKoperasi = $lastSaldoRows->sum('saldo');

            if ($totalSimpananKoperasi <= 0) {
                return back()->with('error', 'Total simpanan koperasi tidak boleh nol atau minus. Tidak dapat menghitung SHU.');
            }

            $shuPeriod = ShuPeriod::create([
                'periode' => $validated['periode'],
                'total_shu' => $validated['total_shu'],
                'persen_jasa_modal' => $validated['persen_jasa_modal'],
                'persen_jasa_usaha' => $validated['persen_jasa_usaha'],
                'total_simpanan_koperasi' => $totalSimpananKoperasi,
                'total_penjualan_koperasi' => $totalPenjualanKoperasi,
            ]);

            // (Dihapus) Reset jasa karena kolom tidak ada

            // Hitung & simpan distribusi statis
            $this->calculateAndDistributeSHU($shuPeriod);

            DB::commit();
            return back()->with('success', 'Periode SHU berhasil dibuat dan dihitung.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat periode SHU: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses SHU: ' . $e->getMessage());
        }
    }

    public function show(ShuPeriod $period)
    {
        $distributions = ShuDistribution::with('user')
            ->where('shu_period_id', $period->id)
            ->get();

        return view('SHU.detail-shu', compact('period', 'distributions'));
    }

    private function calculateAndDistributeSHU(ShuPeriod $period)
    {
        $anggota = User::where('role', 'anggota')->with('simpanan')->get();

        $alokasiJasaModal = $period->total_shu * ($period->persen_jasa_modal / 100);
        $alokasiJasaUsaha = $period->total_shu * ($period->persen_jasa_usaha / 100);

        foreach ($anggota as $member) {
            // Total simpanan anggota (pokok + wajib)
            $totalSimpananAnggota = $member->simpanan
                ? ((int)($member->simpanan->total_pokok ?? 0) + (int)($member->simpanan->total_wajib ?? 0))
                : 0;

            // SALDO TERAKHIR user ini (pakai id terbesar; aman jika tidak ada created_at)
            $totalBelanjaAnggota = DetailTransaksi::where('id_user', $member->id_user)
                ->orderByDesc('id')
                ->value('saldo') ?? 0;

            // SHU Jasa Modal
            $shuJasaModal = ($period->total_simpanan_koperasi > 0)
                ? ($totalSimpananAnggota / $period->total_simpanan_koperasi) * $alokasiJasaModal
                : 0;

            // SHU Jasa Usaha
            $shuJasaUsaha = ($period->total_penjualan_koperasi > 0)
                ? ($totalBelanjaAnggota / $period->total_penjualan_koperasi) * $alokasiJasaUsaha
                : 0;

            ShuDistribution::create([
                'shu_period_id' => $period->id,
                'id_user' => $member->id_user,
                'total_simpanan_anggota' => $totalSimpananAnggota,
                'total_belanja_anggota' => $totalBelanjaAnggota,
                'shu_jasa_modal' => $shuJasaModal,
                'shu_jasa_usaha' => $shuJasaUsaha,
            ]);
        }
    }
    public function cetak($id)
    {
        $period = ShuPeriod::with(['distributions.user'])->findOrFail($id);

        $distributions = $period->distributions;

        $pdf = Pdf::loadView('shu.cetak', compact('period', 'distributions'))
                ->setPaper('a4', 'landscape'); 

        return $pdf->stream('detail_shu_periode_'.$period->periode.'.pdf');
    }
}
