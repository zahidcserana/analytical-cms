<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function calculate()
    {
        $subTotal = 0;

        foreach ($this->invoiceItems as $invoiceItem) {
            $subTotal += $invoiceItem->area * $invoiceItem->price * $invoiceItem->quantity;
        }

        $this->total = $subTotal - $this->discount;
        $this->sub_total = $subTotal;

        if ($this->total == $this->paid) {
            $this->status = 'paid';
        }

        $this->update();
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
