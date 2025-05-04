<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasar extends Model
{
    use HasFactory;

    protected $table = 'pasar';

    protected $guarded = [
        'id',
    ];

    public function dpp()
    {
        return $this->belongsTo(DPP::class);
    }
}
