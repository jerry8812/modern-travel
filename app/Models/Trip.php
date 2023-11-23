<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'source',
        'status',
        'amount_of_people',
        'total_price',
        'comment'
    ];

    protected $cast = [
        'status' => TripStatus::class
    ];

    public function tripDays()
    {
        return $this->hasMany(TripDay::class);
    }
}
