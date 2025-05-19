<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisTanaman extends Model
{
    protected $table = 'jenis_tanaman';
    
    protected $guarded = ['id'];

    public function dtphp(): BelongsTo 
    {
        return $this->belongsTo(DTPHP::class, 'id', 'jenis_tanaman_id');
    }
}
