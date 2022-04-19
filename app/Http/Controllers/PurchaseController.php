<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Arr;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Purchase\StoreRequest;
use App\Http\Requests\Purchase\UpdateRequest;
use App\Http\Requests\PurchaseItem\StoreRequest as PurchaseItemStoreRequest;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
        $collection = Purchase::query();

        $collection->when($request->status, function ($q) use ($request) {
            return $q->where('status', $request['status']);
        });
        $collection->when($request->supplier_id, function ($q) use ($request) {
            return $q->where('supplier_id', $request['supplier_id']);
        });
        $collection->when($request->purchase_no, function ($q) use ($request) {
            return $q->where('purchase_no', 'like', '%' . $request['purchase_no'] . '%');
        });

        if (!empty($request->daterange)) {
            $daterange = explode(' - ', $request->daterange);
            $dateS = date('Y-m-d', strtotime($daterange[0]));
            $dateE = !empty($daterange[1]) ? date('Y-m-d', strtotime($daterange[1])) : $dateS;

            $collection = $collection->whereDate('created_at', '>=', $dateS)->whereDate('created_at', '<=', $dateE);
        }

        $purchases = $collection->latest('id')->paginate(20);

        $collection = $collection->get();

        $summary = [
            'sub_total' => 0,
            'discount' => 0,
            'total' => 0,
            'paid' => 0,
        ];

        foreach ($collection as $row) {
            $summary['sub_total'] += $row->sub_total;
            $summary['discount'] += $row->discount;
            $summary['total'] += $row->total;
            $summary['paid'] += $row->paid;
        }

        $data['summary'] = $summary;
        $data['purchases'] = $purchases;
        $data['query'] = $query;
        $data['suppliers'] = Supplier::select('id', 'name')->get();

        return view('purchases.index', $data);
    }

    public function create()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $purchase = Purchase::latest()->first();

        if ($purchase) {
            $purchaseNo = sprintf("%0" . config("settings.invoice_size") . "d", $purchase->id + 1);
        } else {
            $purchaseNo = sprintf("%0" . config("settings.invoice_size") . "d", 1);
        }

        $data['suppliers'] = $suppliers;
        $data['purchaseNo'] = $purchaseNo;


        return view('purchases.create', $data);
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();
        $item = $input['item'];
        Arr::forget($input, 'item');

        DB::beginTransaction();

        try {
            $purchase = Purchase::create($input);

            $purchaseItems = [];
            for ($i = 0; $i < sizeof($item['description']); $i++) {
                $purchaseItems[] = [
                    "description" => $item['description'][$i],
                    "size" => $item['size'][$i],
                    "quantity" => $item['quantity'][$i],
                    "price" => $item['price'][$i],
                    "amount" => $item['amount'][$i]
                ];
            }

            foreach ($purchaseItems as $purchaseItem) {
                $purchaseItem['purchase_id'] = $purchase->id;
                $purchaseItemInput = PurchaseItemStoreRequest::make($purchaseItem);
                $this->saveItems($purchaseItemInput);
            }

            $purchase->refresh();
            $purchase->calculate();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('purchases.create');
        }

        return redirect()->route('purchases.index');
    }

    public function saveItems(PurchaseItemStoreRequest $request)
    {
        $input = $request->validated();
        PurchaseItem::create($input);
    }

    public function edit(Purchase $purchase)
    {
        return view('purchases.edit', compact('purchase'));
    }

    public function update(UpdateRequest $request, Purchase $purchase)
    {
        $input = $request->validated();

        $purchase->update($input);
        $purchase->calculate();
        $purchase->refresh();

        return back()->with('success', 'Purchase successfully updated.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->purchaseItems()->delete();
        $purchase->delete();

        return back()->with('success', 'Purchase successfully deleted.');
    }
}
