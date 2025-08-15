<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */

    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount',
        'type',
        'description',
        'date',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
