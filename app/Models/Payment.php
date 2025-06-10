<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_tenant_id',
        'amount',
        'payment_date',
        'payment_status',
        'payment_method',
        'billing_period',
        'penalty_fee',
        'payment_photo',
    ];

    public function roomTenant()
    {
        return $this->belongsTo(RoomTenant::class);
    }
}
