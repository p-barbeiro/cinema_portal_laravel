<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    use HasFactory;

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function genre(): HasOne
    {
        return $this->hasOne(Genre::class,'genre_code','code');
    }
}
