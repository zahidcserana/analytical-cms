<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Expense Create</h4>
                <a href="{{ route('expenses.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="POST" action="{{ route('expenses.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Expense type</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12" name="expense_type">
                                <option value="">-Select-</option>
                                @foreach (Config::get('settings.expenseType') as $key => $value)
                                    <option {{ old('expense_type') == $key ? "selected='selected'" : '' }} value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Bill No</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Bill No" type="text" name="bill_no" value="{{ old('bill_no') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Amount" type="text" name="amount" value="{{ old('amount') }}">
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Expense Date</label>
                        <div class="col-sm-12 col-md-4">
                            <input value="{{ date('Y-m-d') }}" class="form-control my-date-picker" name="expense_date" placeholder="Select Date" type="text" autocomplete="off">
                        </div>
                    </div>

                    <div class="text-center">
                        <x-button class="btn btn-primary">{{ __('Save') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            new Expense();
        </script>
    @endpush
</x-app-layout>
