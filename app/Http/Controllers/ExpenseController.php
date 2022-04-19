<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Requests\Expense\UpdateRequest;
use Illuminate\Support\Arr;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->query();
        $collection = Expense::query();

        $collection->when($request->expense_type, function ($q) use ($request) {
            return $q->where('expense_type', 'like', '%' . $request['expense_type'] . '%');
        });
        $collection->when($request->bill_no, function ($q) use ($request) {
            return $q->where('bill_no', 'like', '%' . $request['bill_no'] . '%');
        });
        if (!empty($request->daterange)) {
            $daterange = explode(' - ', $request->daterange);
            $dateS = date('Y-m-d', strtotime($daterange[0]));
            $dateE = !empty($daterange[1]) ? date('Y-m-d', strtotime($daterange[1])) : $dateS;

            $collection = $collection->whereDate('expense_date', '>=', $dateS)->whereDate('expense_date', '<=', $dateE);
        }

        $expenses = $collection->latest('id')->paginate(20);

        $data['expenses'] = $expenses;
        $data['query'] = $query;

        return view('expenses.index', $data);
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $user = Expense::create($input);

        return redirect()->route('expenses.index')->with('success', 'Expense successfully added.');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', ['expense' => $expense]);
    }

    public function details(Expense $expense)
    {
        return response()->json($expense);
    }

    public function update(UpdateRequest $request, Expense $expense)
    {
        $input = $request->validated();

        $expense->update($input);

        return back()->with('success', 'Expense successfully updated.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return back()->with('success', 'Expense successfully deleted.');
    }
}
