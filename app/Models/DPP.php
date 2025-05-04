<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPP extends Model
{
    use HasFactory;

    protected $table = 'dinas_perindustrian_perdagangan';

    protected $fillable = [
        'user_id',
        'pasar', 
        'jenis_bahan_pokok', 
        'gambar_bahan_pokok', 
        'kg_harga',
        'tanggal_dibuat'
    ];

    public $timestamps = false;

    public function pasars()
    {
        return $this->hasMany(Pasar::class, 'pasar');
    }

    public function bahanPokoks()
    {
        return $this->hasMany(BahanPokok::class, 'jenis_bahan_pokok');
    }
}
