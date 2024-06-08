<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public $timestamps = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class, 'genre_code', 'code');
    }

    protected $fillable = [
        'code',
        'name',
    ];

}
