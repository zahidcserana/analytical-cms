<?php

namespace App\Listeners;

use App\Events\InvoiceIssued;
use App\Models\Invoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerBalance
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceIssued  $event
     * @return void
     */
    public function handle(InvoiceIssued $event)
    {
        $due = 0;

        foreach ($event->invoice->customer->dueInvoices as $invoice) {
            $due += $invoice->total - $invoice->paid;
        }

        $event->invoice->customer->balance = $due;
        $event->invoice->customer->update();
    }
}
