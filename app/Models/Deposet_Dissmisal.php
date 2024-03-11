<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposet_Dissmisal extends Model
{
    use HasFactory;
    protected $tbale = 'deposets_dissmisals';

    protected $fillable = [
        'ammount',
        'file',
        'info',
        'type',
        'users_id',
        'repo_id'
    ];

    public function User():BelongsTo
    {
        return $this->belongsTo(User::class, 'repo_id');
    }
}
