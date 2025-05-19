<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisIkan extends Model
{
    protected $table = 'jenis_ikan';
    
    protected $guarded = ['id'];

    public function dp(): BelongsTo 
    {
        return $this->belongsTo(DP::class, 'id', 'jenis_ikan_id');
    }
}
