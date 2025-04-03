<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DP extends Model
{
    use HasFactory;

    protected $table = 'dinas_perikanan';

    protected $fillable = [
        'user_id',
        'tanggal_input', 
        'jenis_ikan', 
        'ton_produksi'
    ];

    public $timestamps = false;
}
