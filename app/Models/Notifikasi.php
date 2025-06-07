<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'tanggal_pesan' => 'datetime',
        'completed_at' => 'datetime',
        'is_read' => 'boolean',
        'is_completed' => 'boolean'
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    // Scope untuk notifikasi yang belum selesai
    public function scopeIncomplete($query)
    {
        return $query->where('is_completed', false);
    }

    // Scope untuk notifikasi yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    // Scope untuk notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Accessor untuk status text
    public function getStatusTextAttribute()
    {
        if ($this->is_completed) {
            return 'Selesai';
        }
        
        return $this->is_read ? 'Dibaca' : 'Belum Dibaca';
    }

    // Accessor untuk status color
    public function getStatusColorAttribute()
    {
        if ($this->is_completed) {
            return 'green';
        }
        
        return $this->is_read ? 'blue' : 'red';
    }
}
