<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    public function user() {
        return $this->hasMany(User::class);
    }

    public function notifications() {
        return $this->hasMany(Notifikasi::class, 'notifikasi_id');
    }
}
