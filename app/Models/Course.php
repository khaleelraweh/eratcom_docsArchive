<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// use Illuminate\Foundation\Auth\User;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Course extends Model

{
    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait;

    protected $guarded = [];

    // for translatable field 
    public $translatable = ['title', 'subtitle', 'slug', 'description', 'address'];




    // searchable lab 
    protected $searchable = [
        'columns' => [
            'courses.title' => 10,
        ]
    ];



    const NEW_COURSE = 0;        // when he start the course
    const COURSE_COMPLETED = 1;  // when the validation is finished
    const UNDER_PROCESS = 2;     // When he clicked to send for  review Course
    const FINISHED = 3;         // when the admin is finishing the review 
    const PUBLISHED = 4;        // when admin allow to publish the course the status will be true 
    const REJECTED = 5;         // when admin reject published course or reject course the status will be false


    public function course_status()
    {

        switch ($this->course_status) {
            case 0:
                $result = __('panel.course_new_course');
                break;
            case 1:
                $result = __('panel.course_completed');
                break;
            case 2:
                $result = __('panel.course_under_process');
                break;
            case 3:
                $result = __('panel.course_review_finished');
                break;
            case 4:
                $result = __('panel.course_published');
                break;
            case 5:
                $result = __('panel.coure_rejected');
                break;
        }
        return $result;
    }

    public function statusWithLabel()
    {

        switch ($this->course_status) {
            case 0:
                $result = '<label class="badge bg-success text-white p-2">' .  __('panel.course_new_course')  . '</label>';
                break;
            case 1:
                $result = '<label class="badge bg-secondary text-light p-2">' . __('panel.course_completed') . '</label>';
                break;
            case 2:
                $result = '<label class="badge bg-warning text-dark p-2">' .  __('panel.course_under_process') . '</label>';
                break;
            case 3:
                $result = '<label class="badge bg-primary text-light p-2">' . __('panel.course_review_finished') . '</label>';
                break;
            case 4:
                $result = '<label class="badge bg-primary text-light p-2">' . __('panel.course_published') . '</label>';
                break;
            case 5:
                $result = '<label class="badge bg-danger text-white p-2">' . __('panel.coure_rejected') . '</label>';
                break;
        }
        return $result;
    }


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

    public function certificate()
    {
        return $this->certificate ? __('panel.certificate_yes') : __('panel.certificate_no');
    }

    public function language()
    {
        if ($this->language == 1)
            return __('panel.language_ar');
        else if ($this->language == 2)
            return __('panel.language_en');
        else {
            return __('panel.language_ar');
        }
    }

    public function skill_level()
    {
        if ($this->skill_level == 1)
            return __('transf.Beginner Level');
        else if ($this->skill_level == 2)
            return __('transf.Intermediate Level');
        else if ($this->skill_level == 3) {
            return __('transf.Advance Level');
        } else if ($this->skill_level == 4) {
            return __('transf.All Levels');
        }
    }
    public function course_type()
    {
        if ($this->course_type == 1)
            return __('transf.Course presence');
        else if ($this->course_type == 2)
            return __('transf.Course enrolled');
    }

    public function featured()
    {
        return $this->featured ? __('panel.yes') : __('panel.no');
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function scopeCourse($query)
    {
        return $query->whereSection(1);
    }

    public function scopeEvent($query)
    {
        return $query->whereSection(2);
    }


    public function scopeHasQuantity($query)
    {
        return $query->where('quantity', '>=', -1);
    }

    public function scopeActiveCourseCategory($query)
    {
        return $query->whereHas('courseCategory', function ($query) {
            $query->whereStatus(1);
        });
    }


    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id', 'id');
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

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }



    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }


    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    // public function instructors(): MorphToMany
    // {
    //     return $this->morphToMany(User::class, 'userable');
    // }

    public function instructors(): MorphToMany
    {
        return $this->morphToMany(User::class, 'userable')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'instructor');
            });
    }

    // check if the user is instructor 
    public function isInstructor($userId)
    {
        return $this->instructors()->where('user_id', $userId)->exists();
    }


    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'userable');
    }

    public function specializations()
    {
        return $this->hasManyThrough(Specialization::class, User::class);
    }


    public function topics(): MorphMany
    {
        return $this->morphMany(Topic::class, 'topicable');
    }

    public function requirements(): MorphMany
    {
        return $this->morphMany(Requirement::class, 'requirementable');
    }

    public function objectives(): MorphMany
    {
        return $this->morphMany(Objective::class, 'objectiveable');
    }

    public function intendeds(): MorphMany
    {
        return $this->morphMany(Intended::class, 'intendedable');
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }

    public function totalLessonsCount()
    {
        // Sum the count of lessons in each course section
        return $this->sections->sum(function ($section) {
            return $section->lessons->count();
        });
    }
}
