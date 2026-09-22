<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function halaqahs()
    {
        return $this->hasMany(Halaqah::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Label: "2026/2027 — Ganjil"
     */
    public function getLabelAttribute(): string
    {
        return $this->academicYear->nama . ' — ' . ucfirst($this->tipe);
    }
}
