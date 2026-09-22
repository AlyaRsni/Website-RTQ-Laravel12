<?php

namespace App\Http\Controllers\Siakad\Santri;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Santri;
use App\Models\Subject;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Get the authenticated santri instance
     */
    private function getSantri()
    {
        return Santri::where('user_id', auth()->id())
            ->with(['dormitory', 'halaqahs.semester.academicYear', 'halaqahs.ustadz'])
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $santri = $this->getSantri();

        // Get all halaqah IDs for this santri
        $halaqahIds = $santri->halaqahs->pluck('id');

        // Get all grades for this santri
        $grades = Grade::where('santri_id', $santri->id)
            ->with(['subject.category', 'halaqah.semester.academicYear'])
            ->orderBy('subject_id')
            ->orderByDesc('created_at')
            ->get();

        // Group grades by subject
        $gradesBySubject = $grades->groupBy('subject_id')->map(function ($subjectGrades) {
            $subject = $subjectGrades->first()->subject;

            // Group by tipe
            $byTipe = $subjectGrades->groupBy('tipe');

            // Calculate averages per tipe
            $avgPerTipe = [];
            foreach (['harian', 'tugas', 'uts', 'uas'] as $tipe) {
                $tipeGrades = $byTipe->get($tipe, collect());
                $avgPerTipe[$tipe] = [
                    'count' => $tipeGrades->count(),
                    'avg'   => $tipeGrades->count() > 0 ? round($tipeGrades->avg('nilai'), 1) : null,
                ];
            }

            // Overall average for this subject
            $overallAvg = $subjectGrades->count() > 0 ? round($subjectGrades->avg('nilai'), 1) : null;

            return (object) [
                'subject'      => $subject,
                'grades'       => $subjectGrades,
                'by_tipe'      => $avgPerTipe,
                'overall_avg'  => $overallAvg,
                'total_count'  => $subjectGrades->count(),
            ];
        })->values();

        // Overall stats
        $overallStats = [
            'total_mapel'  => $gradesBySubject->count(),
            'total_nilai'  => $grades->count(),
            'rata_rata'    => $grades->count() > 0 ? round($grades->avg('nilai'), 1) : null,
            'nilai_max'    => $grades->count() > 0 ? round($grades->max('nilai'), 1) : null,
            'nilai_min'    => $grades->count() > 0 ? round($grades->min('nilai'), 1) : null,
        ];

        return view('siakad.santri.nilai', compact(
            'santri', 'gradesBySubject', 'overallStats'
        ));
    }
}
