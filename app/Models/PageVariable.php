<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVariable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pageGroup(): BelongsTo
    {
        return $this->belongsTo(PageGroup::class);
    }
}
