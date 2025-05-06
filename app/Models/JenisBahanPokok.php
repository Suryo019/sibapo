<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisBahanPokok extends Model
{
    protected $table = 'jenis_bahan_pokok';
    
    protected $guarded = ['id'];

    public function dpp(): BelongsTo 
    {
        return $this->belongsTo(DPP::class, 'id', 'jenis_bahan_pokok_id');
    }
}
