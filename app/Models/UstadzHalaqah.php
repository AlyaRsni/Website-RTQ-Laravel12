<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UstadzHalaqah extends Model
{
    protected $table = 'ustadzs';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function halaqahs()
    {
        return $this->hasMany(Halaqah::class, 'ustadz_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
