window.Invoice = function () {
    $(document).ready(function() {
        customerSelect2();
        datePicker();

        var subtotal = $("#subtotal").val();
        var total = $("#total").val();
        var intRegex = /^\d+$/;
        let itemId = [];
        var invoiceId = $("#invoice_id").val();

        $(".calculation").on("keyup change", function(e) {
            calculation();
        })

        $(".calculate").on("keyup change", function(e) {
            calculate();
        })

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
                        $("#subtotal").val(subtotal);
                    }
                }
            });
        });

        $("#post-form").validate({
            rules: {
                width: {
                    required: true,
                    number: true
                },
                length: {
                    required: true,
                    number: true
                },
                quantity: {
                    required: true,
                    digits: true
                },
                price: {
                    required: true,
                    number: true
                }
            },
            messages: {
                width: {
                    required: "*",
                    number: "*"
                },
                length: {
                    required: "*",
                    number: "*"
                },
                quantity: {
                    required: "*",
                    digits: "*"
                },
                price: {
                    required: "*",
                    number: "*"
                }
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

                        ajaxMessageBox('Data successfully saved.', true);

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
                                "<td class='text-center'>" + data.width + "&times;"+ data.length + "</td>" +
                                "<td class='text-center'>" + data.area + "</td>" +
                                "<td class='text-center'>" + data.quantity + "</td>" +
                                "<td class='text-right'>" + data.price + "</td>" +
                                "<td class='text-right'>" + data.amount + "</td> </tr>";

                            $("#invoice-item").append(markup);
                            calculate();
                            $("#subtotal").val(subtotal);
                        }
                    }
                });
            }
        });

        function calculation() {
            let length = $("#length").val();
            let width = $("#width").val();
            let color = $("#color").val();
            if(intRegex.test(color)) {
                let quantity = $("#quantity").val(color);
            }
            let quantity = $("#quantity").val();
            let price = $("#price").val();

            $("#area").val(length * width * quantity);
            let area = $("#area").val();

            $("#amount").val(setAmount(area * price));
        }

        function setAmount($amount)
        {
            return $amount < 150 ? 150 : $amount;
        }

        function calculate() {
            let discount = $("#discount").val();
            let total = subtotal - discount;

            console.log('subtotal: ' + subtotal);
            console.log('discount: ' + discount);
            console.log('total: ' + total);

            $("#total").val(total.toFixed(2));

            let paid = $("#paid").val();

            if (paid > total) {
                paid = total;

                $("#paid").val(paid)
            }

            let due = total - paid;
            $("#due").text(due.toFixed(2));
        }
    });
};
