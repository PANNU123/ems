<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable=[
        'academic_id',
        'subject_name',
        'subject_slug',
        'status',
    ];

    public function academy(){
        return $this->belongsTo(AcademicType::class,'academic_id');
    }
}
