<?php

namespace App\Models;

use App\Models\JenisIkan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DP extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dinas_perikanan';

    protected $guarded = ['id'];

    public function jenis_ikan(): HasMany
    {
        return $this->hasMany(JenisIkan::class, 'id', 'jenis_ikan_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
