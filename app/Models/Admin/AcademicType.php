<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicType extends Model
{
    use HasFactory;
    protected $fillable=[
        'academic_type_name',
        'academic_type_slug',
        'status',
    ];
}
