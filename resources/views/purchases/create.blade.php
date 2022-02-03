<x-app-layout>
    <div class="min-height-200px mb-10">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Purchase Create</h4>
                <a href="{{ route('purchases.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="post" action="{{ route('purchases.store') }}" autocomplete="off" novalidate>
                    @csrf
                    <div class="pd-20">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-2">
                                <input value="{{ $purchaseNo }}" class="form-control" name="purchase_no" placeholder="Purchase No" type="text" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <select class="custom-select col-12" name="supplier_id" required>
                                    <option value="">-- Select Supplier --</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <input value="{{ date('Y-m-d') }}" class="form-control my-date-picker" name="purchase_date" placeholder="Select Date" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row item-div">
                            <div class="col-sm-12 col-md-4">
                                <input class="form-control" type="text" placeholder="Description" id="description">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input class="form-control" placeholder="Size" type="text" id="size">
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <input class="form-control calculation" placeholder="Quantity" type="number" id="quantity" min="1">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input class="form-control calculation" placeholder="Rate" type="number" step="any" id="price" min="1">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input class="form-control" placeholder="Amount" type="text" id="amount" readonly>
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <a id="item-add-btn" class="btn btn-block btn-success">{{ __('Add') }}</a>
                            </div>
                        </div>

                        <table class="table table-bordered stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Description</th>
                                    <th class="text-center">Size</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Rate</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="purchase-item">
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-lg btn-danger delete-row">{{ __('Delete') }}</a>
                            </div>
                            <div class="col-md-4">
                                @include("layouts.alerts.ajax_success")
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8 mt-10">
                            </div>
                            <div class="col-4">
                                <table class="table">
                                    <tr>
                                        <td>Sub Total:</td>
                                        <td><input type="number" class="form-control" id="subtotal" value="0" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Discount:</td>
                                        <td><input class="form-control calculate" type="number" name="discount" id="discount" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td><input type="number" class="form-control" id="total" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Paid/Adv:</td>
                                        <td><input class="form-control calculate" type="number" name="paid" id="paid" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Balance/Due:</td>
                                        <td><p id="due"></p></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div style="display: flex">
                            <div style="flex: 4"></div>
                            <x-button style="flex: 1;" class="btn btn-success btn-lg">{{ __('Save') }}</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            new Purchase();
        </script>
    @endpush
</x-app-layout>
