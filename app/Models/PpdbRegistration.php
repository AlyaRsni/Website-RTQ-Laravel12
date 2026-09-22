<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbRegistration extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'pernah_hafal_quran' => 'boolean',
            'finalisasi_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get current active step (1-7)
     */
    public function getCurrentStep(): int
    {
        // Step 7: Already has nomor peserta
        if ($this->nomor_peserta) return 7;

        // Step 6: Verification phase
        if ($this->status_verifikasi === 'terverifikasi') return 7;
        if (in_array($this->status_verifikasi, ['menunggu_verifikasi_berkas', 'perlu_perbaikan'])) return 6;

        // Step 5: Finalisasi
        if ($this->finalisasi_at) return 6;

        // Step 4: Berkas
        if ($this->status_berkas !== 'selesai' && $this->status_kontak === 'selesai') return 4;

        // Step 3: Kontak
        if ($this->status_kontak !== 'selesai' && $this->status_data_diri === 'selesai') return 3;

        // Step 2: Data diri
        if ($this->status_pembayaran === 'diterima' && $this->status_data_diri !== 'selesai') return 2;

        // Step 1: Pembayaran
        return 1;
    }

    /**
     * Check if a step is accessible
     */
    public function isStepAccessible(int $step): bool
    {
        return match ($step) {
            1 => true,
            2 => $this->status_pembayaran === 'diterima',
            3 => $this->status_pembayaran === 'diterima' && $this->status_data_diri === 'selesai',
            4 => $this->status_pembayaran === 'diterima' && $this->status_data_diri === 'selesai' && $this->status_kontak === 'selesai',
            5 => $this->status_pembayaran === 'diterima' && $this->status_data_diri === 'selesai' && $this->status_kontak === 'selesai' && $this->status_berkas === 'selesai',
            6 => $this->finalisasi_at !== null,
            7 => $this->status_verifikasi === 'terverifikasi',
            default => false,
        };
    }

    /**
     * Check if registration needs revision (unlocked for editing)
     */
    public function needsRevision(): bool
    {
        return $this->status_verifikasi === 'perlu_perbaikan';
    }

    /**
     * Check if step is completed
     */
    public function isStepCompleted(int $step): bool
    {
        return match ($step) {
            1 => $this->status_pembayaran === 'diterima',
            2 => $this->status_data_diri === 'selesai',
            3 => $this->status_kontak === 'selesai',
            4 => $this->status_berkas === 'selesai',
            5 => $this->finalisasi_at !== null,
            6 => $this->status_verifikasi === 'terverifikasi',
            7 => $this->nomor_peserta !== null,
            default => false,
        };
    }

    /**
     * Get step status label
     */
    public function getStepStatus(int $step): string
    {
        return match ($step) {
            1 => $this->bukti_pembayaran ? 'Selesai' : 'Belum Upload',
            2 => match ($this->status_data_diri) {
                'belum_isi' => 'Belum Diisi',
                'draft' => 'Draft',
                'selesai' => 'Selesai',
                default => 'Belum Diisi',
            },
            3 => match ($this->status_kontak) {
                'belum_isi' => 'Belum Diisi',
                'selesai' => 'Selesai',
                default => 'Belum Diisi',
            },
            4 => match ($this->status_berkas) {
                'belum_upload' => 'Belum Upload',
                'draft' => 'Draft',
                'selesai' => 'Selesai',
                default => 'Belum Upload',
            },
            5 => $this->finalisasi_at ? 'Terkirim' : 'Belum Finalisasi',
            6 => match ($this->status_verifikasi) {
                'belum_diajukan' => 'Belum Diajukan',
                'menunggu_verifikasi_berkas' => 'Menunggu Verifikasi',
                'perlu_perbaikan' => 'Perlu Perbaikan',
                'terverifikasi' => 'Terverifikasi',
                default => 'Belum Diajukan',
            },
            7 => $this->nomor_peserta ? 'Nomor: ' . $this->nomor_peserta : 'Belum Generate',
            default => '-',
        };
    }

    /**
     * Get overall progress percentage (Step 1-5 only = user-controlled)
     */
    public function getProgressPercentage(): int
    {
        $completed = 0;
        for ($i = 1; $i <= 5; $i++) {
            if ($this->isStepCompleted($i)) $completed++;
        }
        return (int) round(($completed / 5) * 100);
    }

    /**
     * Check if registration is finalized AND locked.
     * When status is 'perlu_perbaikan', registration is unlocked for editing.
     */
    public function isFinalized(): bool
    {
        return $this->finalisasi_at !== null && $this->status_verifikasi !== 'perlu_perbaikan';
    }

    /**
     * Check if registration was ever submitted (finalisasi_at set)
     */
    public function wasEverFinalized(): bool
    {
        return $this->finalisasi_at !== null;
    }

    /**
     * ============================================================
     * Generate Nomor Peserta
     * ============================================================
     * Format: [TAHUN_AJARAN] + [NOMOR_URUT_2DIGIT]
     *
     * Contoh: 20270101, 20270102, 20270103, ...
     *
     * ► UBAH PREFIX di bawah ini jika ingin mengganti format.
     *   Misal: tahun ajaran 2028 → ganti menjadi '202801'
     * ============================================================
     */
    public static function generateNomorPeserta(): string
    {
        // ╔══════════════════════════════════════════╗
        // ║  UBAH PREFIX DI SINI SETIAP TAHUN AJARAN ║
        // ╚══════════════════════════════════════════╝
        $prefix = '202701';

        $lastNumber = self::where('nomor_peserta', 'like', "{$prefix}%")
            ->orderByDesc('nomor_peserta')
            ->value('nomor_peserta');

        $nextSeq = 1;
        if ($lastNumber) {
            // Ambil angka setelah prefix
            $seqPart = substr($lastNumber, strlen($prefix));
            $nextSeq = (int)$seqPart + 1;
        }

        return $prefix . str_pad($nextSeq, 2, '0', STR_PAD_LEFT);
    }
}
