<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_PENDING = 'pending';
    const STATUS_ADJUST = 'adjusted';
    const STATUS_ADVANCED = 'advanced';

    protected $guarded = [];

    protected $casts = [
        'log' => 'array'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
