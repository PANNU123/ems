<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'subject_id',
        'chapter_name',
        'chapter_slug',
        'status','deleted_at'
    ];
}
