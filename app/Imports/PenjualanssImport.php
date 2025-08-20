<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenjualanssImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Cek apakah tanggal ada dan valid (bisa dicek numerik)
        if (!isset($row['tanggal']) || empty($row['tanggal'])) {
            return null; // skip baris ini jika tanggal kosong
        }

        $tanggal = $row['tanggal'];

        // Jika tanggal berupa angka serial Excel, konversi
        if (is_numeric($tanggal)) {
            $tanggal = $this->excelSerialToDate($tanggal);
        } else {
            // Bisa tambah validasi format tanggal jika perlu
        }

        return new Penjualan([
            'tanggal' => $tanggal,
            'jumlah_terjual' => $row['penjualan'] ?? 0,
        ]);
    }

    private function excelSerialToDate($serial)
    {
        // Excel serial date dimulai dari 1899-12-30
        return Carbon::createFromDate(1899, 12, 30)->addDays($serial)->format('Y-m-d');
    }
}
