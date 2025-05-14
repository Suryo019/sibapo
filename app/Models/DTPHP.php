<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DTPHP extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dinas_tanaman_pangan_holtikultural_perkebunan';

    protected $fillable = [
        'user_id',
        'jenis_komoditas', 
        'tanggal_input', 
        'ton_volume_produksi', 
        'hektar_luas_panen'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
