<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Customer;
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
            $dateE = date('Y-m-d', strtotime($daterange[1]));

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

    public function customers()
    {
        $customers = Customer::get();
        $summary['balance'] = 0;

        foreach ($customers as $customer) {
            $summary['balance'] += $customer->balance;
        }

        $data['customers'] = $customers;
        $data['summary'] = $summary;


        return view('reports.customers.index', $data);
    }
}
