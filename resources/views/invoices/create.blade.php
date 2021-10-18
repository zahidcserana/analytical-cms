<x-app-layout>
    <div class="min-height-200px mb-10">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Invoice Create</h4>
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                @include("layouts.alert")
                <form method="POST" action="{{ route('invoices.store') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-2">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio1" name="type" class="custom-control-input" value="2" {{ old('type') == 2 ? 'checked': '' }}>
                                <label class="custom-control-label" for="customRadio1">Local</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="type" class="custom-control-input" value="1" {{ empty(old('type')) || (old('type') == 1) ? 'checked': '' }}>
                                <label class="custom-control-label" for="customRadio2">Corporate</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2" title="Invoice No">
                            <input value="{{ $invoiceNo }}" class="form-control" name="invoice_no" placeholder="Invoice No" type="text" autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <select class="custom-select col-12" name="customer_id">
                                <option value="">-Select Customer-</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <input value="{{ date('Y-m-d') }}" class="form-control my-date-picker" name="invoice_date" placeholder="Select Date" type="text" autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-2" title="Total">
                            <input class="form-control" name="total" placeholder="Amount" type="text" autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-1">
							<button type="submit" class="btn" data-bgcolor="#00b489" data-color="#ffffff"><i class="fa fa-random"></i> {{ __('Next') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
