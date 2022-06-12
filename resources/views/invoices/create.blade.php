<x-app-layout>
    <div class="min-height-200px mb-10">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Invoice Create</h4>
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form class="form-inline" method="POST" action="{{ route('invoices.store') }}">
                    @csrf
                    <input value="{{ date('Y-m-d') }}" name="invoice_date" type="hidden">
                    <input type="hidden" name="type" value="1">
                    <div class="form-group mb-2">
                        <label for="invoice_no">Invoice No</label>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input value="{{ $invoiceNo }}" class="form-control" name="invoice_no" id="invoice_no" placeholder="Invoice No" type="text" autocomplete="off">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="customer_id">Customer</label>
                    </div>
                    <div class="form-group mx-sm-3 mb-2" style="width: 20%;">
                        <select class="customer-select2 customer-select" name="customer_id" id="customer_id" data-customer-id="{{ old('customer_id') ?? '' }}"></select>
                    </div>
                    <button type="submit" class="btn mb-2" data-bgcolor="#00b489" data-color="#ffffff"><i class="fa fa-random"></i> {{ __('Next') }}</button>
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
