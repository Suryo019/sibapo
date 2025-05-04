<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BahanPokok extends Model
{
    use HasFactory;

    protected $table = 'bahan_pokok';

    protected $fillable = [
        'nama_bpokok',
        'gambar_bpokok',
    ];

    public function dpp()
    {
        return $this->belongsTo(DPP::class);
    }
}
