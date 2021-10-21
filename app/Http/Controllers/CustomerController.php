<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
        $collection = Customer::query();

        $collection->when($request->name, function ($q) use ($request) {
            return $q->where('name', $request['name']);
        });
        $collection->when($request->mobile, function ($q) use ($request) {
            return $q->where('mobile', $request['mobile']);
        });
        $collection->when($request->email, function ($q) use ($request) {
            return $q->where('email', $request['email']);
        });

        $customers = $collection->paginate(20);

        $data['customers'] = $customers;

        return view('customers.index', $data);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $user = Customer::create($input);

        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
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
}
