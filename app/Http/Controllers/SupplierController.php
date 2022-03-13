<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\Supplier\StoreRequest;
use App\Http\Requests\Supplier\UpdateRequest;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
        $collection = Supplier::query();

        $collection->when($request->name, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request['name'] . '%');
        });
        $collection->when($request->mobile, function ($q) use ($request) {
            return $q->where('mobile', 'like', '%' . $request['mobile'] . '%');
        });
        $collection->when($request->email, function ($q) use ($request) {
            return $q->where('email', 'like', '%' . $request['email'] . '%');
        });

        $suppliers = $collection->latest('id')->paginate(20);

        $data['suppliers'] = $suppliers;
        $data['query'] = $query;

        return view('suppliers.index', $data);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $user = Supplier::create($input);

        return redirect()->route('suppliers.index')->with('success', 'Supplier successfully added.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    public function details(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    public function update(UpdateRequest $request, Supplier $supplier)
    {
        $input = $request->validated();

        $supplier->update($input);

        return back()->with('success', 'Supplier successfully updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return back()->with('success', 'Supplier successfully deleted.');
    }
}
