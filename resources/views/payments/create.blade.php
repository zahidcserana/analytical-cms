<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Payment Create</h4>
                <a href="{{ route('payments.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                @include("layouts.alert")
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Customer</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12" name="customer_id">
                                <option value="">-Select-</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 col-md-2 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-4">
                            <input class="form-control" placeholder="Amount" type="number" name="amount" value="{{ old('amount') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Payment Method</label>
                        <div class="col-sm-12 col-md-4">
                            <select class="custom-select col-12" name="method">
                                <option value="">-Select-</option>
                                @foreach (Config::get('settings.paymentMethod') as $key => $value)
                                    <option value="{{ $key }}">{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Remarks</label>
                        <div class="col-sm-12 col-md-10">
                            <textarea class="form-control" name="payload" placeholder="Remarks" value="{{ old('payload') }}"></textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <x-button class="btn btn-primary">{{ __('Save') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
