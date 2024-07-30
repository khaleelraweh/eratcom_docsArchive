<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use HasFactory, SearchableTrait, SoftDeletes;

    protected $guarded = [];
    public $timestamps = false;

    public $searchable =  [
        'columns' => [
            'countries.name_native' => 10,
            'countries.name' => 10,
            'countries.region' => 10,
        ]
    ];

    public function status()
    {
        return $this->status ? __('panel.status_active') : __('panel.status_inactive');
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }
}
