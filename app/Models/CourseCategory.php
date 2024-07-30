<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class CourseCategory extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait;
    protected $guarded = [];

    public $translatable = ['title', 'slug', 'description'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

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

    protected $searchable = [
        'columns' => [
            'course_categories.title' => 10,
        ]
    ];

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function scopeRootCategory($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeHasCourses($query)
    {
        return $query->whereHas('Courses');
    }

    public function parent()
    {
        return $this->hasOne(CourseCategory::class, 'id',  'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id', 'id');
    }

    public function appearedChildren()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id', 'id')->where('status', true);
    }

    public static function tree($level = 1)
    {
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereNull('parent_id')
            ->whereStatus(true)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function photo(): MorphOne
    {
        return $this->morphOne(Photo::class, 'imageable');
    }

    public function firstMedia(): MorphOne
    {
        return $this->MorphOne(Photo::class, 'imageable')->orderBy('file_sort', 'asc');
    }

    public function lastMedia(): MorphOne
    {
        return $this->MorphOne(Photo::class, 'imageable')->orderBy('file_sort', 'desc');
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
