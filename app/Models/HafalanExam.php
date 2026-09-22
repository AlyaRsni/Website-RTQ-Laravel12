<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HafalanExam extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal_ujian' => 'date',
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
     * Label kategori ujian
     */
    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'per_juz'  => 'Ujian Per Juz',
            'semester' => 'Ujian Semester',
            'bulanan'  => 'Ujian Bulanan',
            default    => $this->kategori,
        };
    }

    /**
     * Rata-rata nilai bacaan + hafalan
     */
    public function getRataRataAttribute(): float
    {
        return round(($this->nilai_bacaan + $this->nilai_hafalan) / 2, 1);
    }

    /**
     * Label predikat berdasarkan rata-rata
     */
    public function getPredikatAttribute(): string
    {
        $avg = $this->rata_rata;
        return match (true) {
            $avg >= 90 => 'Mumtaz',
            $avg >= 80 => 'Jayyid Jiddan',
            $avg >= 70 => 'Jayyid',
            $avg >= 60 => 'Maqbul',
            default    => 'Perlu Perbaikan',
        };
    }

    /**
     * Range surah display
     */
    public function getRangeSurahAttribute(): string
    {
        if (!$this->surat_mulai && !$this->surat_selesai) {
            return '-';
        }

        $from = $this->surat_mulai ?? '';
        $to   = $this->surat_selesai ?? '';

        if ($from && $to && $from !== $to) {
            return "{$from} → {$to}";
        }

        return $from ?: $to;
    }
}
