<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index(Request $request)
    // {
    //     $tahunTerpilih = $request->input('tahun', date('Y'));

    //     $tahunList = Penjualan::selectRaw('YEAR(tanggal) as tahun')
    //                 ->distinct()
    //                 ->orderBy('tahun', 'desc')
    //                 ->pluck('tahun')
    //                 ->toArray();

    //     $bulanLengkap = array_fill(1, 12, 0);

    //     $penjualan = Penjualan::whereYear('tanggal', $tahunTerpilih)
    //                 ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_terjual) as total')
    //                 ->groupBy('bulan')->orderBy('bulan')
    //                 ->pluck('total', 'bulan')->toArray();

    //     $peramalan = DB::table('peramalans')
    //                 ->join('penjualans', 'peramalans.penjualan_id', '=', 'penjualans.id')
    //                 ->whereYear('penjualans.tanggal', $tahunTerpilih)
    //                 ->selectRaw('MONTH(penjualans.tanggal) as bulan, SUM(peramalans.hasil_peramalan) as total')
    //                 ->groupBy('bulan')
    //                 ->orderBy('bulan')
    //                 ->pluck('total', 'bulan')
    //                 ->toArray();

    //     $penjualan = array_replace($bulanLengkap, $penjualan);
    //     $peramalan = array_replace($bulanLengkap, $peramalan);

    //     $namaBulan = [
    //         1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    //         5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    //         9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    //     ];

    //     return view('welcome', compact(
    //         'tahunList', 'tahunTerpilih', 'penjualan', 'peramalan','namaBulan',
    //     ));
    // }

    public function index(Request $request)
    {
        $tahunTerpilih = $request->input('tahun', date('Y'));
        $bulanTerpilih = $request->input('bulan', date('n')); // default bulan sekarang

        $tahunList = Penjualan::selectRaw('YEAR(tanggal) as tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun')->toArray();

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // jumlah hari dalam bulan dan tahun yang dipilih
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanTerpilih, $tahunTerpilih);
        $hariLengkap = array_fill(1, $jumlahHari, 0);

        // Data Penjualan per hari
        $penjualan = Penjualan::whereYear('tanggal', $tahunTerpilih)->whereMonth('tanggal', $bulanTerpilih)->selectRaw('DAY(tanggal) as hari, SUM(jumlah_terjual) as total')->groupBy('hari')->orderBy('hari')->pluck('total', 'hari')->toArray();

        // Data Peramalan per hari
        $peramalan = DB::table('peramalans')->join('penjualans', 'peramalans.penjualan_id', '=', 'penjualans.id')->whereYear('penjualans.tanggal', $tahunTerpilih)->whereMonth('penjualans.tanggal', $bulanTerpilih)->selectRaw('DAY(penjualans.tanggal) as hari, SUM(peramalans.hasil_peramalan) as total')->groupBy('hari')->orderBy('hari')->pluck('total', 'hari')->toArray();

        $penjualan = array_replace($hariLengkap, $penjualan);
        $peramalan = array_replace($hariLengkap, $peramalan);

        // Label hari
        $hariLabels = [];
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $hariLabels[] = str_pad($i, 2, '0', STR_PAD_LEFT); // ex: 01, 02, ..., 31
        }

        return view('welcome', compact('tahunList', 'tahunTerpilih', 'bulanTerpilih', 'namaBulan', 'penjualan', 'peramalan', 'hariLabels'));
    }
}
