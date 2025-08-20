<?php

namespace App\Http\Controllers;

use App\Models\Alpha;
use Illuminate\Http\Request;
use App\Jobs\UpdatePeramalanJob;

class AlphaController extends Controller
{
    public function updateAlpha(Request $request)
    {
        try {
            $request->validate([
                'alpha' => 'required|numeric|min:0|max:1',
            ]);

            Alpha::create(['alpha' => $request->alpha]);

            UpdatePeramalanJob::dispatch();

            return back()->with('success', 'Alpha berhasil diubah. Data peramalan sedang dihitung ulang.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat merubah nilai Alpha. Silakan coba lagi.');
        }
    }
}
