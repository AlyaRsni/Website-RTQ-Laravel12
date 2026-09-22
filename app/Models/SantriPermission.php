<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SantriPermission extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Label jenis izin
     */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'pulang'   => 'Pulang',
            'sakit'    => 'Sakit',
            'kegiatan' => 'Kegiatan',
            'lainnya'  => 'Lainnya',
            default    => $this->jenis,
        };
    }

    /**
     * Durasi izin dalam hari
     */
    public function getDurasiAttribute(): int
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }

    /**
     * Cek apakah santri terlambat kembali.
     * - Jika izin 1 hari dan ada jam_kembali: bandingkan dengan tanggal_selesai + jam_kembali
     * - Jika multi-hari atau tanpa jam: bandingkan dengan akhir tanggal_selesai (23:59)
     * - Hanya berlaku untuk status disetujui
     */
    public function getIsTerlambatAttribute(): bool
    {
        if (!in_array($this->status, ['disetujui', 'selesai'])) {
            return false;
        }

        $now = Carbon::now();

        // Jika ada jam_kembali, gunakan sebagai batas waktu
        if ($this->jam_kembali) {
            $batas = $this->tanggal_selesai->copy()->setTimeFromTimeString($this->jam_kembali);
            return $now->greaterThan($batas);
        }

        // Tanpa jam_kembali: terlambat jika sudah lewat tanggal_selesai
        return $now->greaterThan($this->tanggal_selesai->copy()->endOfDay());
    }

    /**
     * Hitung keterlambatan dalam format readable
     */
    public function getKeterlambatanAttribute(): ?string
    {
        if (!$this->is_terlambat) {
            return null;
        }

        $now = Carbon::now();

        if ($this->jam_kembali) {
            $batas = $this->tanggal_selesai->copy()->setTimeFromTimeString($this->jam_kembali);
        } else {
            $batas = $this->tanggal_selesai->copy()->endOfDay();
        }

        $diffMinutes = $batas->diffInMinutes($now);

        if ($diffMinutes < 60) {
            return $diffMinutes . ' menit';
        }

        $diffHours = floor($diffMinutes / 60);
        $remainMinutes = $diffMinutes % 60;

        if ($diffHours < 24) {
            return $diffHours . ' jam ' . ($remainMinutes > 0 ? $remainMinutes . ' menit' : '');
        }

        $diffDays = floor($diffHours / 24);
        $remainHours = $diffHours % 24;
        return $diffDays . ' hari ' . ($remainHours > 0 ? $remainHours . ' jam' : '');
    }
}
