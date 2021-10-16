<?php

namespace App\Models;

use App\Events\InvoiceIssued;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_DUE = 'due';

    protected $guarded = [];

    protected $dispatchesEvents = [
        'saved' => InvoiceIssued::class,
    ];

    public function calculate()
    {
        $subTotal = 0;

        foreach ($this->invoiceItems as $invoiceItem) {
            $subTotal += $invoiceItem->area * $invoiceItem->price * $invoiceItem->quantity;
        }

        $this->total = $subTotal - $this->discount;
        $this->sub_total = $subTotal;

        if ((int)$this->total <= (int)$this->paid) {
            $this->status = 'paid';
        } else if ((int)$this->total > (int)$this->paid) {
            $this->status = 'due';
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
