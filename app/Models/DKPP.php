<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DKPP extends Model
{
    use HasFactory;

    protected $table = 'dinas_ketahanan_pangan_peternakan';

    protected $fillable = [
        'user_id',
        'jenis_komoditas', 
        'tanggal_input', 
        'ton_ketersediaan', 
        'ton_kebutuhan_perminggu', 
        'ton_neraca_mingguan', 
        'keterangan'
    ];
}
