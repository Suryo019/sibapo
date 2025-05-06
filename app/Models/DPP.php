<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DPP extends Model
{
    use HasFactory;

    protected $table = 'dinas_perindustrian_perdagangan';

    protected $fillable = [
        'user_id',
        'pasar', 
        'jenis_bahan_pokok', 
        'kg_harga',
        'tanggal_dibuat'
    ];

    public $timestamps = false;

    public function pasar(): HasMany
    {
        return $this->hasMany(Pasar::class, 'id', 'pasar_id');
    }

    public function jenis_bahan_pokok(): HasMany
    {
        return $this->hasMany(JenisBahanPokok::class, 'id', 'jenis_bahan_pokok_id');
    }
}
