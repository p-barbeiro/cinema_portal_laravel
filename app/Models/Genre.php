<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class,'genre_code','code');
    }

    protected $fillable = [
        'code',
        'name',
        'custom',
        'deleted_at',
    ];

}
