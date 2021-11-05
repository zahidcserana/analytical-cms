<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-title h4 pull-left">Invoice No: &nbsp;{{ $invoice->invoice_no }}, &nbsp; Status: {{ $invoice->status }}</h4>
                
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i
                        class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">
                
                @include("layouts.alert")

                @if ($invoice->status != \App\Models\Invoice::STATUS_PAID)
                    <form class="mb-30" id="post-form" method="post" action="javascript:void(0)">
                        @csrf
                        <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-2">
                                <input class="form-control" type="text" placeholder="Buyer" name="buyer" id="buyer">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <input class="form-control" placeholder="Style" type="text" name="style" id="style">
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <input class="form-control calculation" placeholder="Color" type="text" name="color" id="color">
                            </div>
                            <div class="col-sm-12 col-md-2" style="display: flex">
                                <input style="flex: 1" class="form-control calculation" placeholder="Width" type="text" name="width" id="width">
                                <input style="flex: 1" class="form-control calculation" placeholder="Length" type="text"name="length" id="length">
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <input class="form-control" placeholder="Sq. Ins" type="text" name="area" id="area" readonly>
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <input class="form-control calculation" placeholder="Quantity" type="text" name="quantity" id="quantity">
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <input class="form-control calculation" placeholder="Rate" type="number" step="any" name="price" id="price">
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <input class="form-control" placeholder="Amount" type="text" name="amount" id="amount" readonly>
                            </div>
                            <div class="col-sm-12 col-md-1">
                                <button type="submit" id="send_form" class="btn btn-block btn-success">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                @endif

                <table class="table table-bordered stripe hover nowrap">
                    <thead>
                        <tr>
                            @if ($invoice->status != \App\Models\Invoice::STATUS_PAID)
                                <th>Select</th>
                            @endif
                            <th>Buyer</th>
                            <th>Style</th>
                            <th>Color</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Sq. Ins</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Rate</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-item">
                        @foreach ($invoice->invoiceItems as $invoiceItem)
                            <tr>
                                @if ($invoice->status != \App\Models\Invoice::STATUS_PAID)
                                    <td><input type='checkbox' name='record' value="{{ $invoiceItem->id }}"></td>
                                @endif
                                <td>{{ $invoiceItem->buyer }}</td>
                                <td>{{ $invoiceItem->style }}</td>
                                <td>{{ $invoiceItem->color }}</td>
                                <td class="text-center">{{ $invoiceItem->width }} &times; {{ $invoiceItem->length }}</td>
                                <td class="text-center">{{ $invoiceItem->area }}</td>
                                <td class="text-center">{{ $invoiceItem->quantity }}</td>
                                <td class="text-right">{{ $invoiceItem->price }}</td>
                                <td class="text-right">{{ $invoiceItem->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-4">
                        @if ($invoice->status != \App\Models\Invoice::STATUS_PAID)
                                <x-button class="btn btn-lg btn-danger delete-row">{{ __('Delete') }}</x-button>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @include("alerts.success")
                    </div>
                </div>


                <form method="post" action="{{ route('invoices.update', ['invoice' => $invoice]) }}" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <div class="row">
                        <div class="col-8 mt-10">
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Created By</label>
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control" name="created_by" placeholder="Created By" type="text" value="{{ $invoice->created_by }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Received By</label>
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control" placeholder="Received By" type="text" name="received_by" value="{{ $invoice->received_by }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <table class="table">
                                <tr>
                                    <td>Sub Total:</td>
                                    <td><input type="text" class="form-control" id="subtotal" readonly value="{{ $invoice->sub_total }}"></td>
                                </tr>
                                <tr>
                                    <td>Discount:</td>
                                    <td><input class="form-control calculate" type="text" name="discount" id="discount" value="{{ $invoice->discount }}"></td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td><input type="text" class="form-control" id="total" readonly value="{{ $invoice->total }}"></td>
                                </tr>
                                <tr>
                                    <td>Paid/Adv:</td>
                                    <td><input class="form-control calculate" type="text" name="paid" id="paid" value="{{ $invoice->paid }}"></td>
                                </tr>
                                <tr>
                                    <td>Balance/Due:</td>
                                    <td><p id="due">{{ $invoice->total - $invoice->paid }}</p></td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                    <td>
                                        <input value="{{ $invoice->invoice_date }}" class="form-control my-date-picker" name="invoice_date" placeholder="Select Date" type="text" autocomplete="off">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if ($invoice->status != \App\Models\Invoice::STATUS_PAID)
                        <div style="display: flex">
                            <div style="flex: 4"></div>
                            <x-button style="flex: 1;" class="btn btn-success btn-lg">{{ __('Save') }}</x-button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
        <script>
            new Invoice();
        </script>
    @endpush
</x-app-layout>
