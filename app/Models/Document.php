<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Document extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait, SoftDeletes;
    protected $guarded = [];
    public $translatable = ['doc_name', 'slug', 'doc_content'];


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('doc_name')
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

    public function doc_status()
    {
        if ($this->doc_status == 0) {
            return __('panel.status_inactive');
        } elseif ($this->doc_status == 1) {
            return __('panel.status_active');
        }
    }

    protected $searchable = [
        'columns' => [
            'documents.doc_name' => 10,
            'documents.doc_content' => 10,
        ]
    ];

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function documentTemplate(): BelongsTo
    {
        return $this->belongsTo(DocumentTemplate::class);
    }
}
