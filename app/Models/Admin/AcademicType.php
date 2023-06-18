<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicType extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'academic_type_name',
        'academic_type_slug',
        'status','deleted_at'
    ];
}
