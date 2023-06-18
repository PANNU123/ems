<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'chapter_id','question_type_id','difficulty_level',
        'marks','question_text','academic_id',
        'question_cat_id', 'hint', 'question_detail','deleted_at'
    ];

    public function mcqquestion(){
        return $this->hasMany(McqQuestion::class,'question_id');
    }
}
