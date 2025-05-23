<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pasar extends Model
{
    protected $table = 'pasar';
    
    protected $guarded = ['id'];

    public function dpp(): BelongsTo 
    {
        return $this->belongsTo(DPP::class,'id', 'pasar_id');
    }
}
