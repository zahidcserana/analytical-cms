<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $data['customers'] = Customer::get();

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(UpdateRequest $request, Customer $customer)
    {
        $input = $request->validated();

        $customer->update($input);

        return redirect()->back()->withStatus(__('Customer successfully updated.'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->withStatus(__('Customer successfully deleted.'));
    }
}
