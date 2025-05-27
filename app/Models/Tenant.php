<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fullname',
        'ktp_photo',
        'status',
        'payee_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
public function roomTenants()
    {
        return $this->hasMany(RoomTenant::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payee()
    {
        return $this->belongsTo(User::class, 'payee_id');
    }
}
