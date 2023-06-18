<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'academic_id',
        'subject_name',
        'subject_slug',
        'status','deleted_at'
    ];

    public function academy(){
        return $this->belongsTo(AcademicType::class,'academic_id');
    }
}
