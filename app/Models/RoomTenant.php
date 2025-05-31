<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'tenant_id',
        'start_date',
        'end_date',
        'status',
        'payee_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function payee()
    {
        return $this->belongsTo(Tenant::class, 'payee_id');
    }
}
