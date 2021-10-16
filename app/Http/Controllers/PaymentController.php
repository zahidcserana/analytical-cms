<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\Payment\StoreRequest;
use App\Http\Requests\Payment\UpdateRequest;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
        $collection = Payment::query();

        $collection->when($request->status, function ($q) use ($request) {
            return $q->where('status', $request['status']);
        });
        $collection->when($request->customer_id, function ($q) use ($request) {
            return $q->where('customer_id', $request['customer_id']);
        });
        $collection->when($request->method, function ($q) use ($request) {
            return $q->where('method', $request['method']);
        });

        if (!empty($request->daterange)) {
            $daterange = explode(' - ', $request->daterange);
            $dateS = date('Y-m-d', strtotime($daterange[0]));
            $dateE = date('Y-m-d', strtotime($daterange[1]));

            $collection = $collection->whereDate('created_at', '>=', $dateS)->whereDate('created_at', '<=', $dateE);
        }

        $payments = $collection->latest('id')->paginate(20);

        $data['payments'] = $payments;
        $data['customers'] = Customer::select('id', 'name')->get();
        $data['query'] = $query;

        return view('payments.index', $data);
    }

    public function create()
    {
        $data['customers'] = Customer::select('id', 'name')->get();

        return view('payments.create', $data);
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $user = Payment::create($input);

        return redirect()->route('payments.index');
    }

    public function edit(Payment $payment)
    {
        $data['customers'] = Customer::select('id', 'name')->get();
        $data['payment'] = $payment;

        return view('payments.edit', $data);
    }

    public function update(UpdateRequest $request, Payment $payment)
    {
        $input = $request->validated();

        $payment->update($input);

        return redirect()->back()->withStatus(__('Payment successfully updated.'));
    }

    public function adjust(Payment $payment)
    {
        $invoices = $payment->customer->dueInvoices;

        $summary['total'] = 0;
        $summary['paid'] = 0;

        foreach ($invoices as $invoice) {
            $summary['total'] += $invoice->total;
            $summary['paid'] += $invoice->paid;
        }

        $data['invoices'] = $invoices;
        $data['summary'] = $summary;
        $data['payment'] = $payment;

        return view('payments.adjust', $data);
    }

    public function applied(Payment $payment)
    {
        $invoices = $payment->customer->dueInvoices;
        if ($payment->amount > 0) {
            $this->distributePayment($payment, $invoices);
        }

        return redirect()->back()->withStatus(__('Payment successfully adjusted.'));
    }

    private function distributePayment($payment, $invoices)
    {
        $amount = $payment->amount;
        foreach ($invoices as $invoice) {
            $paidAmount = 0;
            $dueAmount = $invoice->total - $invoice->paid;

            if ($amount > $dueAmount) {
                $paidAmount = $dueAmount;
                $status = Invoice::STATUS_PAID;
            } else {
                $paidAmount = $amount;
                $status = Invoice::STATUS_DUE;
            }

            $amount -= $paidAmount;

            $invoice->paid += $paidAmount;
            $invoice->status = $status;
            $invoice->update();

            $payment->amount -= $paidAmount;
            $payment->adjust += $paidAmount;

            app()->logData->logData($invoice, $dueAmount, $paidAmount, $status);

            if ($amount == 0) {
                break;
            }
        }

        $payment->status = $payment->amount > 0 ? Payment::STATUS_ADVANCED : Payment::STATUS_ADJUST;
        $log = app()->logData->getLog();

        if (empty($payment->log)) {
            $payment->log = $log;
        } else {
            $payment->log = array_merge($log, $payment->log);
        }

        $payment->update();
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->back()->withStatus(__('Payment successfully deleted.'));
    }
}
