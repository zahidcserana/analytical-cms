<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Mail\InvoiceDue;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
        $collection = Customer::query();

        $collection->when($request->name, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request['name'] . '%');
        });
        $collection->when($request->mobile, function ($q) use ($request) {
            return $q->where('mobile', 'like', '%' . $request['mobile'] . '%');
        });
        $collection->when($request->email, function ($q) use ($request) {
            return $q->where('email', 'like', '%' . $request['email'] . '%');
        });

        $customers = $collection->latest('id')->paginate(20);

        $data['customers'] = $customers;
        $data['query'] = $query;

        return view('customers.index', $data);
    }

    public function invoices(Customer $customer)
    {
        Mail::to($customer->email)->send(new InvoiceDue($customer));

        return back()->with('success', 'Invoices statement successfully sent.');
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $user = Customer::create($input);

        return redirect()->route('customers.index')->with('success', 'Customer successfully added.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function details(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(UpdateRequest $request, Customer $customer)
    {
        $input = $request->validated();

        $customer->update($input);

        return back()->with('success', 'Customer successfully updated.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer successfully deleted.');
    }

    public function customerSearchById(Customer $customer)
    {
        return response()->json(new CustomerResource($customer));
    }

    public function customerSearch(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = Customer::select("id", "name as text")
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('mobile', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->get();
        } else {
            $data = Customer::select("id", "name as text")
                ->limit(20)
                ->get();
        }
        return response()->json(['results' => $data]);
    }
}
