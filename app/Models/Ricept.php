<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ricept extends Model
{
    use HasFactory;
    protected $table = 'ricepts';
    protected $fillable = [
        'ammount',
        'info',
        'users_id',
        'stores_id'
    ];

    public function User():BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function Store():BelongsTo
    {
        return $this->belongsTo(Stores::class, 'stores_id');
    }
}
