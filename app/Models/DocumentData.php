<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function PageVariable(): BelongsTo
    {
        return $this->belongsTo(PageVariable::class);
    }
}
