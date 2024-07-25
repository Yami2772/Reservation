<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
=======
>>>>>>> cee13b84f8a7895ae4b7d36b7cb065b152acb84c

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'user_id',
    ];
<<<<<<< HEAD
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function service():BelongsToMany
    {
        return $this->belongsToMany(Service::class);
=======

    public function timing(): BelongsTo
    {
        return $this->belongsTo(Timing::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
>>>>>>> cee13b84f8a7895ae4b7d36b7cb065b152acb84c
    }
}
