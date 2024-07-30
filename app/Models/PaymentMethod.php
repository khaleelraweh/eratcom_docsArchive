<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class PaymentMethod extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];


    public $searchable =  [
        'columns' => [
            'payment_methods.name'           => 10,
            'payment_methods.code'           => 10,
            'payment_methods.merchant_email' => 10,
        ]
    ];

    public function status(): string
    {
        return $this->status ? 'مفعل' : 'غير مفعل';
    }

    public function sandbox(): string
    {
        return $this->sandbox ? 'تجريبي' : 'حقيقي';
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
