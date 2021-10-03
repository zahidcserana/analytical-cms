<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\Invoice\StoreRequest;
use App\Http\Requests\Invoice\UpdateRequest;
use App\Http\Requests\InvoiceItem\ItemStoreRequest;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    public function index()
    {
        $data['invoices'] = Invoice::get();

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

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->back()->withStatus(__('Invoice successfully deleted.'));
    }
}
