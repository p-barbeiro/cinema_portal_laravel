<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screening extends Model
{
    use HasFactory;

//    protected $with = ['theater.seats', 'theater'];

    protected $fillable = [
        'theater_id',
        'movie_id',
        'date',
        'start_time'
    ];

    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function isSoldOut()
    {
        return $this->tickets->count() >= ($this?->theater?->seats->count() ?? 9999);
    }
}
