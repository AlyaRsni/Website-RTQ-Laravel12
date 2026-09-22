<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
