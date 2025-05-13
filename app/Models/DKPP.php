<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DKPP extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class);
    }
}
