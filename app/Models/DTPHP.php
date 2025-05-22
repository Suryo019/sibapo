<?php

namespace App\Models;

use App\Models\JenisTanaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DTPHP extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dinas_tanaman_pangan_holtikultural_perkebunan';

    protected $guarded = ['id'];
    
    public function jenis_tanaman(): HasMany
    {
        return $this->hasMany(JenisTanaman::class, 'id', 'jenis_tanaman_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
