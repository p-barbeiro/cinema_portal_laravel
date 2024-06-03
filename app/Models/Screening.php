<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screening extends Model
{
    use HasFactory;

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
        return $this->tickets->count() >= $this->theater->seats->count();
    }

    public function getRemainingSeats()
    {
        return $this->theater->seats->count() - $this->tickets->count();
    }

    public function getFormattedDateAttribute()
    {
        return date('d.M : l', strtotime($this->date));
    }

    public function getFormattedTimeAttribute()
    {
        return date('H:i', strtotime($this->start_time));
    }
}
