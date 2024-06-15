<?php

namespace App\Models;

use EvoMark\LaravelIdObfuscator\Traits\Obfuscatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;
    use Obfuscatable;

    protected $fillable = [
        'purchase_id',
        'seat_id',
        'screening_id',
        'price',
        'qrcode_url',
        'status'
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }
}
