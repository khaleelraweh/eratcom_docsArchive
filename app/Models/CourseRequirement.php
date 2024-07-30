<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class CourseRequirement extends Model
{
    use HasFactory, HasTranslations, SearchableTrait;

    protected $guarded = [];
    public $translatable = ['course_requirement'];

    protected $searchable = [
        'columns' => [

            'course_requirements.course_requirement' => 10,
        ]
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
