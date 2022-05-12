<x-app-layout>
    <div class="min-height-200px mb-10">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Invoice Create</h4>
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="POST" action="{{ route('invoices.store') }}">
                    @csrf
                    <input value="{{ date('Y-m-d') }}" name="invoice_date" type="hidden">
                    <input type="hidden" name="type" value="1">
                    <input value="{{ $invoiceNo }}" name="invoice_no" type="hidden">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-2">&nbsp;</div>
                        <div class="col-sm-12 col-md-2">
                            <label for="customer_id">Select Customer</label>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <select class="customer-select2 customer-select" name="customer_id" data-customer-id="{{ old('customer_id') ?? '' }}"></select>
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
        <style>
            .select2-container {
                box-sizing: border-box;
                display: inline-block;
                margin: 0;
                position: relative;
                vertical-align: middle;
                width: 100% !important;
            }
        </style>
    @endpush
</x-app-layout>
