<?php

namespace App\Components;

use App\Models\Invoice;
use App\Models\Payment;
use function PHPUnit\Framework\isNull;

class LogComponent
{
    private $invoiceId;
    private $invoiceNo;
    private $dueAmount;
    private $paidAmount;
    private $invoiceStatus;
    private $logData = [];

    public function __construct()
    {
    }

    public function logData(Invoice $invoice, $dueAmount, $paidAmount, $invoiceStatus)
    {
        $this->invoiceId = $invoice->id;
        $this->invoiceNo = $invoice->invoice_no;
        $this->dueAmount = $dueAmount;
        $this->paidAmount = $paidAmount;
        $this->invoiceStatus = $invoiceStatus;
        $this->logData[] = $this->makeLog();
    }

    public function makeLog()
    {
        return [
            'invoiceId' => $this->invoiceId,
            'invoiceNo' => $this->invoiceNo,
            'dueAmount' => $this->dueAmount,
            'paidAmount' => $this->paidAmount,
            'invoiceStatus' => $this->invoiceStatus,
        ];
    }

    public function getLog()
    {
        return $this->logData;
    }
}
