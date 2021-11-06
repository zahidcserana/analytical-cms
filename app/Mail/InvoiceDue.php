<?php

namespace App\Mail;

use App\Models\Customer;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceDue extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invoices = $this->customer->dueInvoices;
        $summary = [
            'sub_total' => 0,
            'discount' => 0,
            'total' => 0,
            'paid' => 0,
        ];

        foreach ($invoices as $invoice) {
            $summary['sub_total'] += $invoice->sub_total;
            $summary['discount'] += $invoice->discount;
            $summary['total'] += $invoice->total;
            $summary['paid'] += $invoice->paid;
        }

        $data['invoices'] = $invoices;
        $data['summary'] = $summary;
        $data['customer'] = $this->customer;

        $pdf = PDF::loadView('customers.invoices', $data);

        return $this->markdown('emails.invoices.dues')
            ->attachData($pdf->output(), 'invoices-' . $this->customer->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
