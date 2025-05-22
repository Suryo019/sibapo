<?php

namespace App\Models;

use App\Models\JenisKomoditasDkpp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DKPP extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dinas_ketahanan_pangan_peternakan';

    protected $guarded = ['id'];

    public function jenis_komoditas_dkpp(): HasMany
    {
        return $this->hasMany(JenisKomoditasDkpp::class, 'id', 'jenis_komoditas_dkpp_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
