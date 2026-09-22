<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerAttendance extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Label waktu shalat
     */
    public function getWaktuLabelAttribute(): string
    {
        return match ($this->waktu_shalat) {
            'subuh'   => 'Subuh',
            'dzuhur'  => 'Dzuhur',
            'ashar'   => 'Ashar',
            'maghrib' => 'Maghrib',
            'isya'    => 'Isya',
            default   => $this->waktu_shalat,
        };
    }
}
