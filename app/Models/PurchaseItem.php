<?php

namespace App\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class)->withTrashed();
    }
}
