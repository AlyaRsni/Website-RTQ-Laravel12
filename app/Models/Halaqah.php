<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halaqah extends Model
{
    protected $guarded = ['id'];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function ustadz()
    {
        return $this->belongsTo(UstadzHalaqah::class, 'ustadz_id');
    }

    public function santris()
    {
        return $this->belongsToMany(Santri::class, 'halaqah_santri')->withTimestamps();
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

    public function disciplineNotes()
    {
        return $this->hasMany(DisciplineNote::class);
    }
}
