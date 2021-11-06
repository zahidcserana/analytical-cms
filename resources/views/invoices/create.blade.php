<x-app-layout>
    <div class="min-height-200px mb-10">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Invoice Create</h4>
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                @include("layouts.alert")
                <form method="POST" action="{{ route('invoices.store') }}">
                    @csrf
                    <input value="{{ date('Y-m-d') }}" name="invoice_date" type="hidden">
                    <input type="hidden" name="type" value="1">
                    <input value="{{ $invoiceNo }}" name="invoice_no" type="hidden">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-2" title="Invoice No">
                            <label for=""></label>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <select class="custom-select col-12" name="customer_id">
                                <option value="">-Select Customer-</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-1">
							<button type="submit" class="btn" data-bgcolor="#00b489" data-color="#ffffff"><i class="fa fa-random"></i> {{ __('Next') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            new Invoice();
        </script>
    @endpush
</x-app-layout>
