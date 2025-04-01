<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DTPHP extends Model
{
    use HasFactory;

    protected $table = 'dinas_tanaman_pangan_holtikultural_perkebunan';

    protected $fillable = [
        'jenis_komoditas', 
        'tanggal_input', 
        'ton_volume_produksi', 
        'hektar_luas_panen'
    ];
}
