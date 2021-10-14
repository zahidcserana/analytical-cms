<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            $this->updateData($invoice);
        }
    }

    public function updateData($invoice)
    {
        $subTotal = 0;

        foreach ($invoice->invoiceItems as $invoiceItem) {
            $subTotal += $invoiceItem->amount;
        }

        $invoice->sub_total = $subTotal;
        $invoice->discount = rand(0, 50);
        $invoice->total = $invoice->sub_total - $invoice->discount;
        $rand = rand(0, 2);

        if ($rand == 1) {
            $invoice->paid = $invoice->total;
            $invoice->status = 'paid';
        } else if ($rand == 2) {
            $invoice->paid = rand(10, $invoice->total - 10);
            $invoice->status = 'due';
        }

        $invoice->update();
        $invoice->refresh();
    }
}
