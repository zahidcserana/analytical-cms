<?php

namespace App\Models;

use NumberFormatter;
use App\Events\InvoiceIssued;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_DUE = 'due';

    const TYPE_CORPORATE = 1;
    const TYPE_LOCAL = 2;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'saved' => InvoiceIssued::class,
    ];

    public function getGrossAttribute()
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $digit->format((int)$this->total);
    }

    public function getDueAttribute()
    {
        $digit = new NumberFormatter("en", NumberFormatter::DEFAULT_STYLE);
        return $digit->format((int)($this->total - $this->paid));
    }

    public function calculate()
    {

        if ($this->type == 1) {
            $subTotal = 0;

            foreach ($this->invoiceItems as $invoiceItem) {
                $subTotal += $this->getAmount($invoiceItem->amount);
            }

            $this->total = $subTotal - $this->discount;
            $this->sub_total = $subTotal;
        }

        if ((int)$this->total <= (int)$this->paid) {
            $this->status = 'paid';
        } else if ((int)$this->total > (int)$this->paid) {
            $this->status = 'due';
        }

        $this->update();
    }

    public function getAmount($amount)
    {
        return $amount < 150 ? 150 : $amount;
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dueTotal()
    {
        return $this->total - $this->paid;
    }
}
