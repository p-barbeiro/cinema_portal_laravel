<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    use HasFactory;

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_code', 'code');
    }

}
