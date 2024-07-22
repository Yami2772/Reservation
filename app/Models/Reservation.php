<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable =[
        'start_time',
        'end_time',
        'user_id',
    ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function service():BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
