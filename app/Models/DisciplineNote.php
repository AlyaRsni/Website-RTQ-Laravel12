<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplineNote extends Model
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
}
