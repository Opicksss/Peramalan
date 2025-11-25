<?php

namespace App\Http\Controllers;

use App\Models\Alpha;
use App\Models\Penjualan;
use App\Models\Peramalan;
use Illuminate\Http\Request;
use App\Imports\PenjualanssImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::orderBy('tanggal', 'desc')->get();
        return view('penjualan', compact('penjualans'));
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request->merge([
                    'tanggal' => $request->tanggal . '-01',
                ]);

                $validatedData = $request->validate([
                    'tanggal' => 'required|date|unique:penjualans,tanggal',
                    'jumlah_terjual' => 'required|numeric',
                ]);

                $penjualan = Penjualan::create($validatedData);
                $this->SES($penjualan);
            });

            return redirect()->back()->with('success', 'Data Penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            // Cek jika pesan error umum, terjemahkan ke Bahasa Indonesia
            if (str_contains($errorMessage, 'The tanggal has already been taken')) {
                $errorMessage = 'Bulan sudah Terdata.';
            } elseif (str_contains($errorMessage, 'The tanggal field is required')) {
                $errorMessage = 'Bulan wajib diisi.';
            } elseif (str_contains($errorMessage, 'The jumlah terjual field is required')) {
                $errorMessage = 'Jumlah terjual wajib diisi.';
            } elseif (str_contains($errorMessage, 'The jumlah terjual must be a number')) {
                $errorMessage = 'Jumlah terjual harus berupa angka.';
            }

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $errorMessage)
                ->withInput();
        }
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        try {
            DB::transaction(function () use ($request, $penjualan) {
                $request->merge([
                    'tanggal' => $request->tanggal . '-01',
                ]);

                $validatedData = $request->validate([
                    'tanggal' => 'required|date|unique:penjualans,tanggal,' . $penjualan->id,
                    'jumlah_terjual' => 'required|numeric',
                ]);

                $penjualan->update($validatedData);

                $penjualan->peramalan()?->delete();

                $this->SES($penjualan);
            });

            return redirect()->back()->with('success', 'Data Penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            if (str_contains($errorMessage, 'The tanggal has already been taken')) {
                $errorMessage = 'Bulan sudah Terdata.';
            } elseif (str_contains($errorMessage, 'The tanggal field is required')) {
                $errorMessage = 'Bulan wajib diisi.';
            } elseif (str_contains($errorMessage, 'The jumlah terjual field is required')) {
                $errorMessage = 'Jumlah terjual wajib diisi.';
            } elseif (str_contains($errorMessage, 'The jumlah terjual must be a number')) {
                $errorMessage = 'Jumlah terjual harus berupa angka.';
            }

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan Saat Update: ' . $errorMessage)
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        try {
            $penjualan->delete();

            return redirect()->back()->with('success', 'Data Penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Data Penjualan. Silakan coba lagi.');
        }
    }

    public function importPenjualan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PenjualanssImport(), $request->file('file'));

        return back()->with('success', 'Data penjualan berhasil diimpor!');
    }

    private function SES($newPenjualan)
    {
        $alpha = Alpha::latest()->first()->alpha ?? 0.5;

        $prev = Penjualan::where('tanggal', '<', $newPenjualan->tanggal)->orderBy('tanggal', 'desc')->first();

        $F_prev = $prev?->peramalan->hasil_peramalan ?? ($prev?->jumlah_terjual ?? $newPenjualan->jumlah_terjual);

        $F_t = $alpha * $newPenjualan->jumlah_terjual + (1 - $alpha) * $F_prev;

        $error = abs($newPenjualan->jumlah_terjual - $F_prev);

        $mape = $newPenjualan->jumlah_terjual != 0 ? abs(($newPenjualan->jumlah_terjual - $F_prev) / $newPenjualan->jumlah_terjual) * 100 : 0;

        Peramalan::create([
            'hasil_peramalan' => $F_t,
            'error' => $error,
            'mape' => $mape,
            'penjualan_id' => $newPenjualan->id,
        ]);
    }
}
