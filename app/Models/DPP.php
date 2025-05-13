<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DPP extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dinas_perindustrian_perdagangan';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function pasar(): HasMany
    {
        return $this->hasMany(Pasar::class, 'id', 'pasar_id');
    }

    public function jenis_bahan_pokok(): HasMany
    {
        return $this->hasMany(JenisBahanPokok::class, 'id', 'jenis_bahan_pokok_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
