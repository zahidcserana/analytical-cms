window.Purchase = function () {
    $(document).ready(function() {
        datePicker();

        let subtotal = $('#subtotal');
        let itemId = [];

        $(".calculation").on("keyup change", function(e) {
            calculation();
        })

        $(".calculate").on("keyup change", function(e) {
            calculate();
        })

        $(".delete-row").click(function() {
            $('.delete-row').html('Deleting..');
            let itemAmount = 0;

            $("table tbody").find('input[name="record"]').each(function() {
                if ($(this).is(":checked")) {
                    itemId.push(this.value);
                    itemAmount = itemAmount + parseFloat(this.value);
                    $(this).parents("tr").remove();
                }
            });

            console.log('itemAmount: ' + itemAmount)
            console.log('itemId')
            console.log(itemId)

            subtotal.val(subtotal.val() - itemAmount);
            calculate();
            $('.delete-row').html('Delete');
        });

        $( "#item-add-btn" ).click(function( event ) {
            if ($("#quantity").val() > 0 && $("#price").val() > 0) {
                $('#item-add-btn').html('Sending..');
                let description = $("#description").val();
                let size = $("#size").val();
                let quantity = $("#quantity").val();
                let price = $("#price").val();
                let amount = $("#amount").val();

                $("#subtotal").val(parseFloat(subtotal.val()) + parseFloat(amount));

                var markup = "<tr>" +
                                "<td><input type='checkbox' name='record' value='"+amount+"'></td>" +
                                "<td><input name='item[description][]' value='"+description +"'></td>" +
                                "<td><input name='item[size][]' value='"+size +"'></td>" +
                                "<td><input name='item[quantity][]' value='"+quantity +"'></td>" +
                                "<td><input name='item[price][]' value='"+price +"'></td>" +
                                "<td><input name='item[amount][]' value='"+amount +"'></td> </tr>";

                $("#purchase-item").append(markup);
                calculate();
                $('#item-add-btn').html('Add');
                ajaxMessageBox('Data successfully saved.', true);
                resetForm();
            }
        });

        function resetForm() {
            $("#description").val("");
            $("#size").val("");
            $("#quantity").val("");
            $("#price").val("");
            $("#amount").val("");
        }

        function calculation() {
            let quantity = $("#quantity").val();
            let price = $("#price").val();

            $("#amount").val(setAmount(quantity * price));
        }

        function setAmount(amount)
        {
            return amount < 0 ? 0 : amount;
        }

        function calculate() {
            let discount = $("#discount").val();
            let subtotalValue = subtotal.val();
            discount = discount > subtotalValue ? subtotalValue : discount;
            let total = subtotalValue - discount;

            $("#total").val(total);

            let paid = $("#paid").val();
            let due = total - paid;
            $("#due").text(due < 0 ? 0 : due.toFixed(2));

            paid = paid > total ? total : paid;
            $("#paid").val(paid)
        }
    });
};
