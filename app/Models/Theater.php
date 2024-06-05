<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Theater extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'photo_filename'
    ];
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function getPhoto()
    {
        if ($this->photo_filename && Storage::exists("public/theaters/{$this->photo_filename}")) {
            return asset("storage/theaters/{$this->photo_filename}");
        } else {
            return asset("img/default_theater.jpg");
        }
    }

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/theaters/{$this->photo_filename}");
    }
}
