<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Customer Edit</h4>
                <a href="{{ route('customers.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                @include("layouts.alert")
                <form method="post" action="{{ route('customers.update', ['customer' => $customer]) }}" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">ID</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" type="text" name="id" value="{{ $customer->id }}" readonly>
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-5">
                            <select class="custom-select col-12" name="status">
                                <option selected="">-Select-</option>
                                <option {{ $customer->status == 'inactive' ? "selected='selected'" : "" }} value="inactive">Inactive</option>
                                <option {{ $customer->status == 'active' ? "selected='selected'" : "" }} value="active">Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" type="text" placeholder="Name" name="name" value="{{ $customer->name }}">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Email</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Email" type="email" name="email" value="{{ $customer->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Phone</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Phone" type="text" name="phone" value="{{ $customer->phone }}">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Mobile</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" type="text" name="mobile" placeholder="Mobile" value="{{ $customer->mobile }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Balance</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Balance" type="text" name="balance" value="{{ $customer->balance }}">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Address</label>
                        <div class="col-sm-12 col-md-5">
                            <textarea class="form-control" name="address" placeholder="Adress">{{ $customer->address }}</textarea>
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
