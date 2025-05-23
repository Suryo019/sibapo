<?php

namespace App\Models;

use App\Models\DKPP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisKomoditasDkpp extends Model
{
    protected $table = 'jenis_komoditas_dkpp';
    
    protected $guarded = ['id'];

    public function dkpp(): BelongsTo 
    {
        return $this->belongsTo(DKPP::class, 'id', 'jenis_komoditas_dkpp_id');
    }
}
