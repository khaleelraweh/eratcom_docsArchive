<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Lesson extends Model
{
    use HasFactory;

    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait;

    protected $guarded = [];

    // for translatable field 
    public $translatable = ['title', 'slug'];


    // searchable lab 
    protected $searchable = [
        'columns' => [
            'courses.title' => 10,
        ]
    ];

    // for slug 
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // to make slug unique 
    protected function generateNonUniqueSlug(): string
    {
        $slugField = $this->slugOptions->slugField;
        $slugString = $this->getSlugSourceString();

        $slug = $this->getTranslations($slugField)[$this->getLocale()] ?? null;

        $slugGeneratedFromCallable = is_callable($this->slugOptions->generateSlugFrom);
        $hasCustomSlug = $this->hasCustomSlugBeenUsed() && !empty($slug);
        $hasNonChangedCustomSlug = !$slugGeneratedFromCallable && !empty($slug) && !$this->slugIsBasedOnTitle();

        if ($hasCustomSlug || $hasNonChangedCustomSlug) {
            $slugString = $slug;
        }

        return MySlugHelper::slug($slugString);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function status()
    {
        return $this->status ? __('panel.status_active') : __('panel.status_inactive');
    }

    public function section()
    {
        return $this->belongsTo(CourseSection::class);
    }

    // get duration in hours and minutes
    public function getDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            return sprintf('%02d hr %02d min', $hours, $minutes);
        } else {
            return sprintf('%02d min', $minutes);
        }
    }
}
