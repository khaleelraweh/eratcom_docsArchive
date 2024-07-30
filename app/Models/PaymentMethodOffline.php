<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class PaymentMethodOffline extends Model
{

    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait;

    protected $guarded = [];
    public $translatable = ['title', 'slug', 'description'];

    protected $searchable = [
        'columns' => [
            'payment_method_offlines.owner_account_name' => 10,
            'payment_method_offlines.customer_account_name' => 10,
            'payment_method_offlines.method_name' => 10,
            'payment_method_offlines.method_description' => 10,
        ]
    ];

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

        // return Str::slug($slugString, $this->slugOptions->slugSeparator, $this->slugOptions->slugLanguage);
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

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas('paymentCategory', function ($query) {
            $query->whereStatus(1);
        });
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

    public function paymentCategory()
    {
        return $this->belongsTo(PaymentCategory::class, 'payment_category_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
