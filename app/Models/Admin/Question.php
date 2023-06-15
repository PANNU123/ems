<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapter_id','question_type_id','difficulty_level',
        'marks','question_text','academic_id',
        'question_cat_id', 'hint', 'question_detail',
    ];
}
