<?php

namespace App\Http\Controllers;

use PDF;
use NumberFormatter;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Invoice\StoreRequest;
use App\Http\Requests\Invoice\UpdateRequest;
use App\Http\Requests\InvoiceItem\ItemStoreRequest;
use App\Mail\InvoiceIssued;
use App\Mail\InvoicePrepared;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
        $collection = Invoice::query();

        $collection->when($request->status, function ($q) use ($request) {
            return $q->where('status', $request['status']);
        });
        $collection->when($request->customer_id, function ($q) use ($request) {
            return $q->where('customer_id', $request['customer_id']);
        });
        $collection->when($request->invoice_no, function ($q) use ($request) {
            return $q->where('invoice_no', 'like', '%'. $request['invoice_no'] . '%');
        });

        if (!empty($request->daterange)) {
            $daterange = explode(' - ', $request->daterange);
            $dateS = date('Y-m-d', strtotime($daterange[0]));
            $dateE = date('Y-m-d', strtotime($daterange[1]));

            $collection = $collection->whereDate('created_at', '>=', $dateS)->whereDate('created_at', '<=', $dateE);
        }

        $invoices = $collection->latest('id')->paginate(20);

        $data['invoices'] = $invoices;
        $data['query'] = $query;
        $data['customers'] = Customer::select('id', 'name')->get();

        return view('invoices.index', $data);
    }

    public function create()
    {
        $customers = Customer::select('id', 'name')->get();
        $invoice = Invoice::latest()->first();

        if ($invoice) {
            $invoiceNo = sprintf("%0" . config("settings.invoice_size") . "d", $invoice->id + 1);
        } else {
            $invoiceNo = sprintf("%0" . config("settings.invoice_size") . "d", 1);
        }

        $data['customers'] = $customers;
        $data['invoiceNo'] = $invoiceNo;


        return view('invoices.create', $data);
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        if ($input['type'] == 2 && empty($input['total'])) {
            return Redirect::back()->withErrors(['msg' => 'Please enter Total amount.']);
        }

        $invoice = Invoice::create($input);
        $invoice->update();

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function addItem(ItemStoreRequest $request, Invoice $invoice)
    {
        $input = $request->validated();

        $invoiceItem = InvoiceItem::create($input);
        $invoice->calculate();
        $invoice->refresh();

        $arr = array('status' => false);

        if ($invoiceItem) {
            $arr = array('status' => true, 'data' => $invoiceItem, 'invoice' => $invoice);
        }

        return response()->json($arr);
    }

    public function deleteItem(Request $request, Invoice $invoice)
    {
        $itemIds = $request->itemId;

        $result = InvoiceItem::whereIn('id', $itemIds)->delete();
        $invoice->calculate();
        $invoice->refresh();

        $arr = array('status' => false);

        if ($result) {
            $arr = array('status' => true, 'invoice' => $invoice);
        }

        return response()->json($arr);
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->type == Invoice::TYPE_LOCAL) {
            return view('invoices.edit_local', ['invoice' => $invoice]);
        }

        return view('invoices.edit', ['invoice' => $invoice]);
    }

    public function update(UpdateRequest $request, Invoice $invoice)
    {
        $input = $request->validated();

        $invoice->update($input);
        $invoice->calculate();
        $invoice->refresh();

        return back()->with('success','Invoice successfully updated.');
    }

    public function show(Invoice $invoice)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->gross = $digit->format((int)$invoice->total);

        return view('invoices.show', ['invoice' => $invoice]);
    }

    public function createPDF(Invoice $invoice)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->gross = $digit->format((int)$invoice->total);

        return view('invoices.pdf', ['invoice' => $invoice]);

        // $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

        // return $pdf->download('invoice.pdf');
    }

    public function preview(Invoice $invoice)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->gross = $digit->format((int)$invoice->total);

        return view('invoices.preview', ['invoice' => $invoice]);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->invoiceItems()->delete();
        $invoice->delete();

        return back()->with('success','Invoice successfully deleted.');
    }

    public function emailing(Request $request, Invoice $invoice)
    {
        $invoice->emailing = true;
        $invoice->update();

        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->gross = $digit->format((int)$invoice->total);

        // return new InvoicePrepared($invoice);

        Mail::to($invoice->customer->email)->send(new InvoicePrepared($invoice));

        return back()->with('success','Invoice successfully sent.');
    }
}
