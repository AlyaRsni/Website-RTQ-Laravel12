<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $guarded = ['id'];

    /**
     * Pemetaan Stage Hafalan Al-Quran (Juz 30 → 1)
     * Pola: 3-2-3-2 bergantian
     */
    public const STAGE_MAP = [
        1  => ['label' => 'Stage 1',  'juz' => [30, 29, 28]],
        2  => ['label' => 'Stage 2',  'juz' => [27, 26]],
        3  => ['label' => 'Stage 3',  'juz' => [25, 24, 23]],
        4  => ['label' => 'Stage 4',  'juz' => [22, 21]],
        5  => ['label' => 'Stage 5',  'juz' => [20, 19, 18]],
        6  => ['label' => 'Stage 6',  'juz' => [17, 16]],
        7  => ['label' => 'Stage 7',  'juz' => [15, 14, 13]],
        8  => ['label' => 'Stage 8',  'juz' => [12, 11]],
        9  => ['label' => 'Stage 9',  'juz' => [10, 9, 8]],
        10 => ['label' => 'Stage 10', 'juz' => [7, 6]],
        11 => ['label' => 'Stage 11', 'juz' => [5, 4, 3]],
        12 => ['label' => 'Stage 12', 'juz' => [2, 1]],
    ];

    /**
     * Info lengkap stage hafalan santri
     */
    public function getStageInfoAttribute(): ?object
    {
        if (!$this->hafalan_stage || !isset(self::STAGE_MAP[$this->hafalan_stage])) {
            return null;
        }

        $stage = $this->hafalan_stage;
        $map   = self::STAGE_MAP[$stage];
        $juz   = $map['juz'];

        $juzLabel = count($juz) === 1
            ? 'Juz ' . $juz[0]
            : 'Juz ' . $juz[0] . ' — ' . end($juz);

        $progressPercent = round(($stage / 12) * 100);

        return (object) [
            'stage'    => $stage,
            'label'    => $map['label'],
            'juz'      => $juz,
            'juz_label' => $juzLabel,
            'progress' => $progressPercent,
        ];
    }

    /**
     * Label singkat stage (contoh: "Stage 3 — Juz 25-23")
     */
    public function getStageLabelAttribute(): string
    {
        $info = $this->stage_info;
        return $info ? "{$info->label} — {$info->juz_label}" : 'Belum ditentukan';
    }

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }

    public function halaqahs()
    {
        return $this->belongsToMany(Halaqah::class, 'halaqah_santri')->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function hafalanJournals()
    {
        return $this->hasMany(HafalanJournal::class);
    }

    public function hafalanExams()
    {
        return $this->hasMany(HafalanExam::class);
    }

    public function disciplineNotes()
    {
        return $this->hasMany(DisciplineNote::class);
    }

    public function santriPermissions()
    {
        return $this->hasMany(SantriPermission::class);
    }

    public function scopeHasRfid($query)
    {
        return $query->whereNotNull('rfid_uid');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Generate NIS otomatis. Format: 202601 + nomor urut 2 digit
     * Contoh: 20260101, 20260102, ...
     */
    public static function generateNis(): string
    {
        $prefix = '202601';

        $lastNis = self::where('nis', 'like', "{$prefix}%")
            ->orderByDesc('nis')
            ->value('nis');

        $nextSeq = 1;
        if ($lastNis) {
            $seqPart = substr($lastNis, strlen($prefix));
            $nextSeq = (int) $seqPart + 1;
        }

        return $prefix . str_pad($nextSeq, 2, '0', STR_PAD_LEFT);
    }
}
