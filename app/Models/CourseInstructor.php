<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseInstructor extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'course_instructor';

    public $timestamps = false;
    public $incrementing = false;
}
