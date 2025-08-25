<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Simpanan;
use App\Models\RiwayatSimpanan;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SimpananController extends Controller
{
    public function index()
    {
        $targetPokok = (int) Setting::firstOrCreate(['key' => 'simpanan_pokok_target'], ['value' => 100000])->value;
        $wajibPerBulan = (int) Setting::firstOrCreate(['key' => 'simpanan_wajib_per_bulan'], ['value' => 10000])->value;
        $periodeTagihanSetting = Setting::firstOrCreate(['key' => 'periode_simpanan_wajib'], ['value' => Carbon::now()->startOfMonth()->toDateString()]);
        $tanggalTagihanBerikutnyaSetting = Setting::firstOrCreate(['key' => 'periode_tagihan_berikutnya'], ['value' => Carbon::now()->addDays(30)->toDateString()]);
        $tanggalTagihanBerikutnya = Carbon::parse($tanggalTagihanBerikutnyaSetting->value);

        if (Carbon::now()->startOfDay()->greaterThanOrEqualTo($tanggalTagihanBerikutnya)) {
            $periodeBaru = Carbon::parse($periodeTagihanSetting->value)->addMonth()->startOfMonth();
            $periodeTagihanSetting->value = $periodeBaru->toDateString();
            $periodeTagihanSetting->save();

            $tanggalTagihanBaru = Carbon::now()->addDays(30);
            $tanggalTagihanBerikutnyaSetting->value = $tanggalTagihanBaru->toDateString();
            $tanggalTagihanBerikutnyaSetting->save();

            $tanggalTagihanBerikutnya = $tanggalTagihanBaru;
            session()->flash('success', 'Siklus tagihan baru telah dimulai secara otomatis!');
        }

        $periodeTagihan = Carbon::parse($periodeTagihanSetting->value)->startOfMonth();

        $simpananData = Simpanan::with('user')->whereHas('user', function ($query) {
            $query->where('role', 'anggota');
        })->get();

        $dataTabel = $simpananData->map(function ($item) use ($periodeTagihan, $targetPokok, $wajibPerBulan) {
            $item->sisa_pokok = max(0, $targetPokok - $item->total_pokok);
            $item->status_pokok = ($item->sisa_pokok <= 0) ? 'Lunas' : 'Belum Lunas';

            $tanggalGabung = Carbon::parse($item->user->tanggal_gabung)->startOfMonth();
            $bulanSeharusnyaDibayar = $tanggalGabung->diffInMonths($periodeTagihan) + 1;
            $totalWajibSeharusnya = $bulanSeharusnyaDibayar * $wajibPerBulan;
            
            $item->tagihan_wajib = max(0, $totalWajibSeharusnya - $item->total_wajib);
            $item->status_wajib = ($item->tagihan_wajib <= 0) ? 'Lunas' : 'Belum Lunas';
            
            return $item;
        });

        return view('simpanan.index', [
            'simpananData' => $dataTabel,
            'periodeTagihan' => $periodeTagihan->format('F Y'),
            'totalTagihanWajib' => $dataTabel->sum('tagihan_wajib'),
            'targetPokok' => $targetPokok,
            'wajibPerBulan' => $wajibPerBulan,
            'tanggalTagihanBerikutnya' => $tanggalTagihanBerikutnya,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|string|exists:users,id_user',
            'jumlah_pokok' => 'nullable|numeric|min:0',
            'jumlah_wajib' => 'nullable|numeric|min:0',
            'jumlah_sukarela' => 'nullable|numeric|min:0',
        ]);

        $simpanan = Simpanan::with('user')->where('id_user', $request->id_user)->firstOrFail();
        $bayarPokok = $request->jumlah_pokok ?? 0;
        $bayarWajib = $request->jumlah_wajib ?? 0;
        $bayarSukarela = $request->jumlah_sukarela ?? 0;

        if ($bayarPokok <= 0 && $bayarWajib <= 0 && $bayarSukarela <= 0) {
            return back()->with('error', 'Tidak ada jumlah pembayaran yang diisi.');
        }

        $targetPokok = (int) Setting::where('key', 'simpanan_pokok_target')->first()->value;
        $wajibPerBulan = (int) Setting::where('key', 'simpanan_wajib_per_bulan')->first()->value;

        DB::beginTransaction();
        try {
            if ($bayarPokok > 0) {
                $sisaPokok = max(0, $targetPokok - $simpanan->total_pokok);
                if ($sisaPokok <= 0) throw new \Exception('Gagal: Simpanan Pokok sudah lunas.');
                if ($bayarPokok > $sisaPokok) throw new \Exception('Gagal: Pembayaran Pokok melebihi sisa tagihan.');

                RiwayatSimpanan::create(['no_transaksi' => 'TRN-P-' . time(), 'id_user' => $simpanan->id_user, 'jenis_simpanan' => 'pokok', 'jumlah' => $bayarPokok, 'tanggal_transaksi' => now(), 'status' => 'berhasil', 'keterangan' => 'Pembayaran Pokok berhasil.']);
                $simpanan->total_pokok += $bayarPokok;
            }

            if ($bayarWajib > 0) {
                $periodeTagihan = Carbon::parse(Setting::where('key', 'periode_simpanan_wajib')->first()->value);
                $totalWajibSeharusnya = (Carbon::parse($simpanan->user->tanggal_gabung)->startOfMonth()->diffInMonths($periodeTagihan) + 1) * $wajibPerBulan;
                $tagihanWajib = max(0, $totalWajibSeharusnya - $simpanan->total_wajib);

                if ($tagihanWajib <= 0) throw new \Exception('Gagal: Simpanan Wajib sudah lunas untuk periode ini.');
                if ($bayarWajib > $tagihanWajib) throw new \Exception('Gagal: Pembayaran Wajib melebihi total tagihan.');
                
                RiwayatSimpanan::create(['no_transaksi' => 'TRN-W-' . time(), 'id_user' => $simpanan->id_user, 'jenis_simpanan' => 'wajib', 'jumlah' => $bayarWajib, 'tanggal_transaksi' => now(), 'status' => 'berhasil', 'keterangan' => 'Pembayaran Wajib berhasil.']);
                $simpanan->total_wajib += $bayarWajib;
            }

            if ($bayarSukarela > 0) {
                RiwayatSimpanan::create(['no_transaksi' => 'TRN-S-' . time(), 'id_user' => $simpanan->id_user, 'jenis_simpanan' => 'sukarela', 'jumlah' => $bayarSukarela, 'tanggal_transaksi' => now(), 'status' => 'berhasil', 'keterangan' => 'Penambahan Simpanan Sukarela berhasil.']);
                $simpanan->total_sukarela += $bayarSukarela;
            }

            $simpanan->save();
            DB::commit();
            return back()->with('success', 'Pembayaran berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function getInfo($id_user)
    {
        try {
            $simpanan = Simpanan::with('user')->where('id_user', $id_user)->firstOrFail();
            
            $targetPokokSetting = Setting::where('key', 'simpanan_pokok_target')->first();
            $wajibPerBulanSetting = Setting::where('key', 'simpanan_wajib_per_bulan')->first();
            $periodeSetting = Setting::where('key', 'periode_simpanan_wajib')->first();

            if (!$targetPokokSetting || !$wajibPerBulanSetting || !$periodeSetting) {
                throw new \Exception('Pengaturan simpanan belum lengkap.');
            }

            $targetPokok = (int) $targetPokokSetting->value;
            $wajibPerBulan = (int) $wajibPerBulanSetting->value;
            
            $sisa_pokok = max(0, $targetPokok - $simpanan->total_pokok);

            $periodeTagihan = Carbon::parse($periodeSetting->value);
            $totalWajibSeharusnya = (Carbon::parse($simpanan->user->tanggal_gabung)->startOfMonth()->diffInMonths($periodeTagihan) + 1) * $wajibPerBulan;
            $tagihan_wajib = max(0, $totalWajibSeharusnya - $simpanan->total_wajib);

            return response()->json([
                'sisa_pokok' => $sisa_pokok,
                'tagihan_wajib' => $tagihan_wajib,
            ]);

        } catch (\Exception $e) {
            Log::error("Gagal mengambil info simpanan untuk user {$id_user}: " . $e->getMessage());
            return response()->json(['error' => 'Tidak dapat memuat data simpanan.'], 500);
        }
    }

    /**
     * FUNGSI : Untuk mengatur alokasi periode tagihan berikutnya.
     */
    public function setNextAllocation(Request $request)
    {
        $minDate = Carbon::now()->addDays(30)->startOfDay();

        $validated = $request->validate([
            'periode_selanjutnya' => 'required|date|after_or_equal:' . $minDate,
        ],[
            'periode_selanjutnya.after_or_equal' => 'Tanggal alokasi harus minimal 30 hari dari sekarang.'
        ]);

        $periodeInput = Carbon::parse($validated['periode_selanjutnya'])->startOfMonth();

        Setting::updateOrCreate(
            ['key' => 'periode_simpanan_wajib'], 
            ['value' => $periodeInput->toDateString()]
        );

        return back()->with('success', 'Periode tagihan simpanan wajib berhasil dialokasikan ke: ' . $periodeInput->format('F Y'));
    }
}
