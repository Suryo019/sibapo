<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DP extends Model
{
    use HasFactory;

    protected $table = 'dinas_periakanan';

    protected $fillable = [
        'tanggal_input', 
        'jenis_ikan', 
        'ton_produksi'
    ];
}
