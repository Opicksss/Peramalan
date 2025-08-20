<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';

    protected $fillable = ['tanggal', 'jumlah_terjual'];

    protected $guarded = ['id'];

    public function peramalan()
    {
        return $this->hasOne(Peramalan::class, 'penjualan_id');
    }
}
