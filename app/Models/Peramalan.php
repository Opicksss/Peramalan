<?php

namespace App\Models;

use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peramalan extends Model
{
    use HasFactory;
    protected $table = 'peramalans';

    protected $fillable = ['hasil_peramalan', 'penjualan_id', 'mape', 'error'];

    protected $guarded = ['id'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}
