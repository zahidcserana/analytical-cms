<x-app-layout>
    <div class="min-height-200px mb-10">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Purchase View</h4>
                <a href="{{ route('purchases.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                <form method="post" action="{{ route('purchases.update', ['purchase' => $purchase]) }}" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="pd-20">
                        <input type="hidden" name="id" value="{{$purchase->id}}">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-2">
                                <input value="{{ $purchase->purchase_no }}" class="form-control" type="text" disabled title="Purchase No">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input value="{{ $purchase->supplier->name }}" class="form-control" type="text" disabled title="Supplier">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input style="text-transform:uppercase" value="{{ $purchase->status }}" class="form-control" type="text" disabled title="Status">
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <input value="{{ $purchase->purchase_date }}" class="form-control my-date-picker" name="purchase_date" placeholder="Select Date" type="text" autocomplete="off" title="Purchase Date">
                            </div>
                        </div>

                        <table class="table table-bordered stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Description</th>
                                    <th class="text-center">Size</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Rate</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="purchase-item">
                                @foreach ($purchase->purchaseItems as $i => $purchaseItem)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $purchaseItem->description }}</td>
                                        <td class="text-center">{{ $purchaseItem->size }}</td>
                                        <td class="text-center">{{ $purchaseItem->quantity }}</td>
                                        <td class="text-right">{{ $purchaseItem->price }}</td>
                                        <td class="text-right">{{ $purchaseItem->amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-8 mt-10">
                            </div>
                            <div class="col-4">
                                <table class="table">
                                    <tr>
                                        <td>Sub Total:</td>
                                        <td><input type="text" class="form-control" id="subtotal" readonly value="{{ $purchase->sub_total }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Discount:</td>
                                        <td><input class="form-control calculate" type="text" name="discount" id="discount" value="{{ $purchase->discount }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td><input type="text" class="form-control" id="total" readonly value="{{ $purchase->total }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Paid/Adv:</td>
                                        <td><input class="form-control calculate" type="text" name="paid" id="paid" value="{{ $purchase->paid }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Balance/Due:</td>
                                        <td><p id="due">{{ $purchase->total - $purchase->paid }}</p></td>
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
