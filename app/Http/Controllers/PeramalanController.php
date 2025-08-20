<?php

namespace App\Http\Controllers;

use App\Models\Alpha;
use App\Models\Penjualan;
use App\Models\Peramalan;

class PeramalanController extends Controller
{
    // public function index()
    // {
    //     $peramalans = Peramalan::with('penjualan')
    //         ->join('penjualans', 'peramalans.penjualan_id', '=', 'penjualans.id')
    //         ->orderBy('penjualans.tanggal', 'desc')
    //         ->select('peramalans.*')
    //         ->get();

    //     $bulan = $peramalans->first();

    //     $alpha = Alpha::latest()->first()->alpha ?? 0.5;

    //     $currentAlphaResult = $this->PeramalanAlpha($alpha);
    //     $mape = $currentAlphaResult['mape'];
    //     $rmse = $currentAlphaResult['rmse'];

    //     $alphas = [];
    //     $bestMape = null;
    //     $bestRmse = null;
    //     $minMape = PHP_INT_MAX;
    //     $minRmse = PHP_INT_MAX;

    //     foreach ([0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9] as $value) {
    //         $result = $this->PeramalanAlpha($value);
    //         $alphas[] = $result;

    //         if ($result['mape'] < $minMape) {
    //             $minMape = $result['mape'];
    //             $bestMape = $value;
    //         }

    //         if ($result['rmse'] < $minRmse) {
    //             $minRmse = $result['rmse'];
    //             $bestRmse = $value;
    //         }
    //     }

    //     return view('peramalan', compact('peramalans', 'bulan', 'mape', 'rmse', 'alpha', 'alphas', 'bestMape', 'bestRmse'));
    // }

    public function index()
    {
        $peramalans = Peramalan::with('penjualan')->join('penjualans', 'peramalans.penjualan_id', '=', 'penjualans.id')->orderBy('penjualans.tanggal', 'desc')->select('peramalans.*')->get();

        $hari = $peramalans->first();

        $alpha = Alpha::latest()->first()->alpha ?? 0.5;

        $currentAlphaResult = $this->PeramalanAlpha($alpha);
        $mape = $currentAlphaResult['mape'];
        $rmse = $currentAlphaResult['rmse'];
        $mae = $currentAlphaResult['mae'];
        $mse = $currentAlphaResult['mse'];
        $mase = $currentAlphaResult['mase'];

        $alphas = [];

        // Untuk mencari alpha terbaik berdasarkan error terkecil
        $bestMape = $bestRmse = $bestMae = $bestMse = $bestMase = null;

        $minMape = $minRmse = $minMae = $minMse = $minMase = PHP_INT_MAX;

        foreach ([0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9] as $value) {
            $result = $this->PeramalanAlpha($value);
            $alphas[] = $result;

            if ($result['mape'] < $minMape) {
                $minMape = $result['mape'];
                $bestMape = $value;
            }

            if ($result['rmse'] < $minRmse) {
                $minRmse = $result['rmse'];
                $bestRmse = $value;
            }

            if ($result['mae'] < $minMae) {
                $minMae = $result['mae'];
                $bestMae = $value;
            }

            if ($result['mse'] < $minMse) {
                $minMse = $result['mse'];
                $bestMse = $value;
            }

            if ($result['mase'] < $minMase) {
                $minMase = $result['mase'];
                $bestMase = $value;
            }
        }

        return view('peramalan', compact('peramalans', 'hari', 'mape', 'rmse', 'mae', 'mse', 'mase', 'alpha', 'alphas', 'bestMape', 'bestRmse', 'bestMae', 'bestMse', 'bestMase'));
    }

    private function PeramalanAlpha($alpha)
    {
        $penjualans = Penjualan::orderBy('tanggal')->get();


        $F_prev = $penjualans->first()->jumlah_terjual ?? 0;

        $totalMape = 0;
        $totalRmse = 0;
        $totalMae = 0;
        $totalMse = 0;
        $naiveErrors = [];
        $count = 0;

        for ($i = 1; $i < $penjualans->count(); $i++) {
            $naiveErrors[] = abs($penjualans[$i]->jumlah_terjual - $penjualans[$i - 1]->jumlah_terjual);
        }
        $naiveDenominator = count($naiveErrors) > 0 ? array_sum($naiveErrors) / count($naiveErrors) : 1;

        foreach ($penjualans as $index => $penjualan) {
            if ($index === 0) {
                continue;
            }

            $F_t = $alpha * $penjualan->jumlah_terjual + (1 - $alpha) * $F_prev;

            $actual = $penjualan->jumlah_terjual;
            $forecast = $F_prev;
            $error = $actual - $forecast;

            $mape = $actual != 0 ? abs($error / $actual) * 100 : 0;
            $rmse = pow($error, 2);
            $mae = abs($error);
            $mse = pow($error, 2);
            $mase = $naiveDenominator != 0 ? abs($error) / $naiveDenominator : 0;

            $totalMape += $mape;
            $totalRmse += $rmse;
            $totalMae += $mae;
            $totalMse += $mse;
            $count++;

            $F_prev = $F_t;
        }

        $avgMape = $count > 0 ? $totalMape / $count : 0;
        $avgRmse = $count > 0 ? sqrt($totalRmse / $count) : 0;
        $avgMae = $count > 0 ? $totalMae / $count : 0;
        $avgMse = $count > 0 ? $totalMse / $count : 0;
        $avgMase = $count > 0 ? $totalMae / $count / ($naiveDenominator ?: 1) : 0;

        return [
            'alpha' => $alpha,
            'mape' => round($avgMape, 2),
            'rmse' => round($avgRmse, 2),
            'mae' => round($avgMae, 2),
            'mse' => round($avgMse, 2),
            'mase' => round($avgMase, 2),
        ];
    }
}
