<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Supplier Create</h4>
                <a href="{{ route('suppliers.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="POST" action="{{ route('suppliers.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" type="text" placeholder="Name" name="name" value="{{ old('name') }}">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Email</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Email" type="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Phone</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" placeholder="Phone" type="text" name="phone" value="{{ old('phone') }}">
                        </div>
                        <label class="col-sm-12 col-md-1 col-form-label">Mobile</label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" type="text" name="mobile" placeholder="Mobile" value="{{ old('mobile') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-1 col-form-label">Address</label>
                        <div class="col-sm-12 col-md-5">
                            <textarea class="form-control" name="address" placeholder="Adress" value="{{ old('address') }}"></textarea>
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
