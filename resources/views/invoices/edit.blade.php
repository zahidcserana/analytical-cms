<x-app-layout>
    <div class="min-height-200px">
        <div class="card-box mb-30">
            <div class="pd-20 clearfix">
                <h4 class="text-blue h4 pull-left">Invoice No: &nbsp;{{ $invoice->invoice_no }}, &nbsp; Status: {{ $invoice->status }}</h4>
                <a href="{{ route('invoices.index') }}" class="btn btn-info pull-right"><i
                        class="fa fa-angle-double-left"></i> Back </a>
            </div>
            <div class="pd-20">

                @include("layouts.alert")

                <form class="mb-30" id="post-form" method="post" action="javascript:void(0)">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-2">
                            <input class="form-control" type="text" placeholder="Buyer" name="buyer">
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <input class="form-control" placeholder="Style" type="text" name="style">
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <input class="form-control" placeholder="Color" type="text" name="color">
                        </div>
                        <div class="col-sm-12 col-md-2" style="display: flex">
                            <input style="flex: 1" class="form-control" placeholder="Length" type="text"name="length" id="length" onkeyup="getArea()">
                            <input style="flex: 1" class="form-control" placeholder="Width" type="text" name="width" id="width" onkeyup="getArea()">
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <input class="form-control" placeholder="Sq. Ins" type="text" name="area" id="area" readonly>
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <input class="form-control" placeholder="Quantity" type="text" name="quantity" id="quantity" onkeyup="getAmount()">
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <input class="form-control" placeholder="Rate" type="text" name="price" id="price" onkeyup="getAmount()">
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <input class="form-control" placeholder="Amount" type="text" name="amount" id="amount" readonly>
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <button type="submit" id="send_form" class="btn btn-block btn-success">{{ __('Add') }}</button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>Select</th>
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
                                <td><input type='checkbox' name='record' value="{{ $invoiceItem->id }}"></td>
                                <td>{{ $invoiceItem->buyer }}</td>
                                <td>{{ $invoiceItem->style }}</td>
                                <td>{{ $invoiceItem->color }}</td>
                                <td class="text-center">{{ $invoiceItem->length }} * {{ $invoiceItem->width }}</td>
                                <td class="text-center">{{ $invoiceItem->area }}</td>
                                <td class="text-center">{{ $invoiceItem->quantity }}</td>
                                <td class="text-right">{{ $invoiceItem->price }}</td>
                                <td class="text-right">{{ $invoiceItem->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-button class="btn btn-lg btn-danger delete-row">{{ __('Delete') }}</x-button>

                <form method="post" action="{{ route('invoices.update', ['invoice' => $invoice]) }}" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <div class="row">
                        <div class="col-8">

                        </div>
                        <div class="col-4">
                            <table class="table">
                                <tr>
                                    <td>Sub Total:</td>
                                    <td id="subtotal">{{ $invoice->sub_total }}</td>
                                </tr>
                                <tr>
                                    <td>Discount:</td>
                                    <td><input class="form-control" type="text" name="discount" id="discount" value="{{ $invoice->discount }}" onkeyup="calculate()"></td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td><p id="total">{{ $invoice->total }}</p></td>
                                </tr>
                                <tr>
                                    <td>Paid/Adv:</td>
                                    <td><input class="form-control" type="text" name="paid" id="paid" value="{{ $invoice->paid }}" onkeyup="calculate()"  ></td>
                                </tr>
                                <tr>
                                    <td>Balance/Due:</td>
                                    <td><p id="due">{{ $invoice->total - $invoice->paid }}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="display: flex">
                        <div style="flex: 4"></div>
                        <x-button style="flex: 1;" class="btn btn-success btn-lg">{{ __('Save') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

        <script>
            var subtotal = @json($invoice->sub_total);
            var total = @json($invoice->total);

            function getArea() {
                let length = $("#length").val();
                let width = $("#width").val();
                $("#area").val(length * width);

                getAmount();
            }

            function getAmount() {
                let area = $("#area").val();
                let price = $("#price").val();
                let quantity = $("#quantity").val();
                $("#amount").val(area * price * quantity);
            }

            function calculate() {
                let discount = $("#discount").val();
                let total = subtotal - discount;
                $("#total").text(total.toFixed(2));

                let paid = $("#paid").val();

                if (paid > total) {
                    paid = total;

                    $("#paid").val(paid)
                }

                let due = total - paid;
                $("#due").text(due.toFixed(2));
            }

            $(document).ready(function() {
                let itemId = [];
                var invoiceId = @json($invoice->id);

                $(".delete-row").click(function() {
                    $("table tbody").find('input[name="record"]').each(function() {
                        if ($(this).is(":checked")) {
                            itemId.push(this.value);
                            $(this).parents("tr").remove();
                        }
                    });

                    console.log('itemId')
                    console.log(itemId)

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('.delete-row').html('Deleting..');
                    $.ajax({
                        url: '/invoice-item-delete/' + invoiceId,
                        type: "POST",
                        data: {
                            invoiceId: invoiceId,
                            itemId: itemId
                        },
                        success: function(response) {
                            if (response.status) {
                                invoice = response.invoice;
                                total = invoice.total;
                                subtotal = invoice.sub_total;
                                calculate();

                                $('.delete-row').html('Delete');
                                $("#subtotal").text(subtotal);
                            }
                        }
                    });
                });
                if ($("#post-form").length > 0) {
                    $("#post-form").validate({
                        rules: {
                            width: {
                                required: true
                            },
                            length: {
                                required: true
                            }
                        },
                        messages: {
                            width: {
                                required: "*"
                            },
                            length: {
                                required: "*"
                            },
                        },
                        submitHandler: function(form) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $('#send_form').html('Sending..');
                            $.ajax({
                                url: '/invoice-item/' + invoiceId,
                                type: "POST",
                                data: $('#post-form').serialize(),
                                success: function(response) {
                                    $('#send_form').html('Add');
                                    $('#res_message').show();
                                    $('#res_message').html(response.msg);
                                    $('#msg_div').removeClass('d-none');

                                    document.getElementById("post-form").reset();

                                    if (response.status) {
                                        data = response.data;
                                        invoice = response.invoice;
                                        total = invoice.total;
                                        subtotal = invoice.sub_total;

                                        var markup = "<tr>" +
                                            "<td><input type='checkbox' name='record' value='" +
                                            data.id + "'></td>" +
                                            "<td>" + data.buyer + "</td>" +
                                            "<td>" + data.style + "</td>" +
                                            "<td>" + data.color + "</td>" +
                                            "<td class='text-center'>" + data.length + "*"+ data.width + "</td>" +
                                            "<td class='text-center'>" + data.area + "</td>" +
                                            "<td class='text-center'>" + data.quantity + "</td>" +
                                            "<td class='text-right'>" + data.price + "</td>" +
                                            "<td class='text-right'>" + data.amount + "</td> </tr>";

                                        $("#invoice-item").append(markup);
                                        calculate();
                                        $("#subtotal").text(subtotal);
                                    }

                                    setTimeout(function() {
                                        $('#res_message').hide();
                                        $('#msg_div').hide();
                                    }, 10000);
                                }
                            });
                        }
                    })
                }
            });
        </script>

        <style>
            .error {
                color: red;
            }

        </style>
    @endpush
</x-app-layout>
