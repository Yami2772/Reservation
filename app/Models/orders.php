<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'start',
        'stop'
    ];
    public function user():HasMany
    {
        return $this->hasMany(User::class);
    }
    public function product():BelongsToMany
    {
        return $this->belongsToMany(product::class);
    }
}
