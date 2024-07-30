<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Instructor extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait;

    protected $guarded = [];
    public $translatable = ['name', 'slug', 'specialization'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
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


    protected $searchable = [
        'columns' => [
            'name' => 10,
        ]
    ];

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

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function firstMedia(): MorphOne
    {
        return $this->MorphOne(Photo::class, 'imageable')->orderBy('file_sort', 'asc');
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
