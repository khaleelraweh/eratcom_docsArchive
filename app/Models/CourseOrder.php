<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'course_order';

    public $timestamps = false;
    public $incrementing = false;
}
