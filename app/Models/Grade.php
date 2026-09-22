<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:2',
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

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
