<?php

namespace App\Http\Controllers;

use PDF;
use NumberFormatter;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Requests\Invoice\StoreRequest;
use App\Http\Requests\Invoice\UpdateRequest;
use App\Http\Requests\InvoiceItem\ItemStoreRequest;

class InvoiceController extends Controller
{
    public function index()
    {
        $data['invoices'] = Invoice::latest('id')->paginate(50);

        return view('invoices.index', $data);
    }

    public function create()
    {
        $data['customers'] = Customer::select('id', 'name')->get();

        return view('invoices.create', $data);
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();


        $invoice = Invoice::create($input);
        $invoice->invoice_no = sprintf("%06d", $invoice->id);
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
        return view('invoices.edit', ['invoice' => $invoice]);
    }

    public function update(UpdateRequest $request, Invoice $invoice)
    {
        $input = $request->validated();

        $invoice->update($input);
        $invoice->calculate();
        $invoice->refresh();

        return redirect()->back()->withStatus(__('Invoice successfully updated.'));
    }

    public function show(Invoice $invoice)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->gross = $digit->format((int)$invoice->total - $invoice->paid);

        return view('invoices.show', ['invoice' => $invoice]);
    }

    public function createPDF(Invoice $invoice)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->gross = $digit->format((int)$invoice->total - $invoice->paid);

        return view('invoices.pdf', ['invoice' => $invoice]);

        // $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

        // return $pdf->download('invoice.pdf');
    }

    public function preview(Invoice $invoice)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $invoice->gross = $digit->format((int)$invoice->total - $invoice->paid);

        return view('invoices.preview', ['invoice' => $invoice]);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->invoiceItems()->delete();
        $invoice->delete();

        return redirect()->back()->withStatus(__('Invoice successfully deleted.'));
    }
}
