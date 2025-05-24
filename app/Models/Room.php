<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'price',
        'description',
        'status',
    ];

    public function roomTenants()
    {
        return $this->hasMany(RoomTenant::class);
    }
}
