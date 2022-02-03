<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_DUE = 'due';

    protected $guarded = [];

    protected $attributes = [
        'status' => self::STATUS_PAID
    ];

    public function calculate()
    {
        $subTotal = 0;

        foreach ($this->purchaseItems as $purchaseItem) {

            $subTotal += $purchaseItem->quantity * $purchaseItem->price;
        }

        $this->sub_total = $subTotal;
        $this->total = $subTotal - $this->discount;

        if ((int)$this->total > (int)$this->paid) {
            $this->status = 'due';
        } else {
            $this->status = 'paid';
        }

        $this->update();
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
