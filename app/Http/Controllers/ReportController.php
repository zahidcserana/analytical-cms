<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function invoices(Request $request)
    {
        $query = $request->query();
        $collection = Invoice::query();

        $collection->when($request->status, function ($q) use ($request) {
            return $q->where('status', $request['status']);
        });

        $collection->when($request->customer_id, function ($q) use ($request) {
            return $q->where('customer_id', $request['customer_id']);
        });

        if (!empty($request->daterange)) {
            $daterange = explode(' - ', $request->daterange);
            $dateS = date('Y-m-d', strtotime($daterange[0]));
            $dateE = !empty($daterange[1]) ? date('Y-m-d', strtotime($daterange[1])) : $dateS;

            $collection = $collection->whereDate('created_at', '>=', $dateS)->whereDate('created_at', '<=', $dateE);
        } else {
            $dateS = Carbon::now()->subDays(30);
            $dateE = Carbon::now();

            $collection = $collection->whereDate('created_at', '>=', $dateS)->whereDate('created_at', '<=', $dateE);

            $dateS = date('m/d/Y', strtotime($dateS));
            $dateE = date('m/d/Y', strtotime($dateE));
            $query['daterange'] = $dateS . ' - ' . $dateE;
        }

        $invoices = $collection->latest('id')->get();
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

        $data['query'] = $query;
        $data['invoices'] = $invoices;
        $data['summary'] = $summary;
        $data['customers'] = Customer::select('id', 'name')->get();

        return view('reports.invoices.index', $data);
    }

    public function customers($print = false)
    {
        $customers = Customer::get();
        $summary['balance'] = 0;

        foreach ($customers as $customer) {
            $summary['balance'] += $customer->balance;
        }

        $data['customers'] = $customers;
        $data['summary'] = $summary;

        if ($print) {
            return view('reports.customers.print', $data);
        }

        return view('reports.customers.index', $data);
    }

    public function payments(Request $request, $print = false)
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
            $dateE = !empty($daterange[1]) ? date('Y-m-d', strtotime($daterange[1])) : $dateS;

            $collection = $collection->whereDate('created_at', '>=', $dateS)->whereDate('created_at', '<=', $dateE);
        } else {
            $dateS = Carbon::now()->subDays(30);
            $dateE = Carbon::now();

            $collection = $collection->whereDate('created_at', '>=', $dateS)->whereDate('created_at', '<=', $dateE);

            $dateS = date('m/d/Y', strtotime($dateS));
            $dateE = date('m/d/Y', strtotime($dateE));
            $query['daterange'] = $dateS . ' - ' . $dateE;
        }

        $payments = $collection->latest('id')->get();

        $summary['amount'] = 0;
        $summary['adjust'] = 0;
        $summary['dues'] = 0;

        foreach ($payments as $payment) {
            $summary['amount'] += $payment->amount;
            $summary['adjust'] += $payment->adjust;
            $summary['dues'] += $payment->dues;
        }

        $data['summary'] = $summary;
        $data['payments'] = $payments;
        $data['customers'] = Customer::select('id', 'name')->get();
        $data['query'] = $query;

        if ($print) {
            return view('reports.payments.print', $data);
        }

        return view('reports.payments.index', $data);
    }
}
