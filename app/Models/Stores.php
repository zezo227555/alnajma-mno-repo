<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stores extends Model
{
    use HasFactory;

    protected $table = 'stores';
    protected $fillable = [
        'name',
        'phone',
        'balance',
        'users_id'
    ];

    public function User():BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
    
    public function Ricept():HasMany
    {
        return $this->hasMany(Ricept::class, 'stores_id');
    }
}
