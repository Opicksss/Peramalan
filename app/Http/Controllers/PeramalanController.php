<?php

namespace App\Http\Controllers;

use App\Models\Alpha;
use App\Models\Penjualan;
use App\Models\Peramalan;

class PeramalanController extends Controller
{

    public function index()
    {
        $peramalans = Peramalan::with('penjualan')->join('penjualans', 'peramalans.penjualan_id', '=', 'penjualans.id')->orderBy('penjualans.tanggal', 'desc')->select('peramalans.*')->get();

        $bulan = $peramalans->first();

        $alpha = Alpha::latest()->first()->alpha ?? 0.5;

        $currentAlphaResult = $this->PeramalanAlpha($alpha);
        $mape = $currentAlphaResult['mape'];
        $mad = $currentAlphaResult['mad'];
        $mse = $currentAlphaResult['mse'];

        $alphas = [];

        // Untuk mencari alpha terbaik berdasarkan error terkecil
        $bestMape = $bestmad = $bestMse = null;

        $minMape = $minRmse = $minMae = $minMse = $minMase = PHP_INT_MAX;

        foreach ([0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9] as $value) {
            $result = $this->PeramalanAlpha($value);
            $alphas[] = $result;

            if ($result['mape'] < $minMape) {
                $minMape = $result['mape'];
                $bestMape = $value;
            }


            if ($result['mad'] < $minMae) {
                $minMae = $result['mad'];
                $bestmad = $value;
            }

            if ($result['mse'] < $minMse) {
                $minMse = $result['mse'];
                $bestMse = $value;
            }

        }

        return view('peramalan', compact('peramalans', 'bulan', 'mape', 'mad', 'mse', 'alpha', 'alphas', 'bestMape', 'bestmad', 'bestMse'));
    }

    private function PeramalanAlpha($alpha)
    {
        $penjualans = Penjualan::orderBy('tanggal')->get();


        $F_prev = $penjualans->first()->jumlah_terjual ?? 0;

        $totalMape = 0;
        $totalMad = 0;
        $totalMse = 0;
        $naiveErrors = [];
        $count = 0;

        foreach ($penjualans as $index => $penjualan) {
            if ($index === 0) {
                continue;
            }

            $F_t = $alpha * $penjualan->jumlah_terjual + (1 - $alpha) * $F_prev;

            $actual = $penjualan->jumlah_terjual;
            $forecast = $F_prev;
            $error = $actual - $forecast;

            $mape = $actual != 0 ? abs($error / $actual) * 100 : 0;
            $mad = abs($error);
            $mse = pow($error, 2);

            $totalMape += $mape;
            $totalMad += $mad;
            $totalMse += $mse;
            $count++;

            $F_prev = $F_t;
        }

        $avgMape = $count > 0 ? $totalMape / $count : 0;
        $avgMae = $count > 0 ? $totalMad / $count : 0;
        $avgMse = $count > 0 ? $totalMse / $count : 0;

        return [
            'alpha' => $alpha,
            'mape' => round($avgMape, 2),
            'mad' => round($avgMae, 2),
            'mse' => round($avgMse, 2),
        ];
    }
}
