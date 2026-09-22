<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HafalanJournal extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function halaqah()
    {
        return $this->belongsTo(Halaqah::class);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Label kualitas dalam bahasa Indonesia
     */
    public function getKualitasLabelAttribute(): string
    {
        return match ($this->kualitas) {
            'mumtaz' => 'Mumtaz (Istimewa)',
            'jayyid_jiddan' => 'Jayyid Jiddan (Sangat Baik)',
            'jayyid' => 'Jayyid (Baik)',
            'maqbul' => 'Maqbul (Cukup)',
            'perlu_perbaikan' => 'Perlu Perbaikan',
            default => $this->kualitas,
        };
    }
}
