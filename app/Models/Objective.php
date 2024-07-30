<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Objective extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];
    public $translatable = ['title'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function objectiveable(): MorphTo
    {
        return $this->morphTo();
    }
}
