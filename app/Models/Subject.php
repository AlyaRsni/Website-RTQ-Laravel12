<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(SubjectCategory::class, 'category_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
