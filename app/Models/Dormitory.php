<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    protected $guarded = ['id'];

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }

    public function getOccupancyAttribute(): int
    {
        return $this->santris()->where('status', 'aktif')->count();
    }
}
