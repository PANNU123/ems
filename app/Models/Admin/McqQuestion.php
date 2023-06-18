<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqQuestion extends Model
{
    use HasFactory;
    protected $fillable =[
        'question_id',
        'option_1','option_2',
        'option_3','option_4',
        'correct_answer',
    ];
}
