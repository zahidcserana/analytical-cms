<x-app-layout>
    <div class="min-height-200px">
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
                        <label class="col-sm-12 col-md-2 col-form-label">Customer</label>
                        <div class="col-sm-12 col-md-6">
                            <select class="custom-select col-12" name="customer_id">
                                <option value="">-Select-</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-button class="btn btn-primary col-sm-12 col-md-4">{{ __('Next') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
