<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
    'text',
    'date',
    'date_time',
    'price',
    'length'
];
public function orders():BelongsToMany
{
    return $this->belongsToMany(orders::class);
}
}
