<?php

namespace App\Mail;

use App\Models\Invoice;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoicePrepared extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('invoices.email', ['invoice' => $this->invoice]);

        return $this->markdown('emails.invoices.prepared')
            ->attachData($pdf->output(), 'invoice-' . $this->invoice->invoice_no . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
