<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        // 'role_id',
        'tanggal_pesan', 
        'pesan'
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
