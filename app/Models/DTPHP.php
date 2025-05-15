<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DTPHP extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dinas_tanaman_pangan_holtikultural_perkebunan';

    protected $guarded = ['id'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
