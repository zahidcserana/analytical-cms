window.Payment = function () {
    $(document).ready(function () {
        datePicker();

        $('.payment-method').on('change', function() {
            console.log( this.value );
            if (this.value == 'Bank') {
                $(".bank-details").show();
            } else {
                $(".bank-details").hide();
            }
        });

        $('.customer-select').on('change', function() {
            console.log( this.value );
            $.ajax({
                url: "/customers/" + this.value + "/details",
                type: "GET",
                success: function (response) {
                    if (response.balance) {
                        $("#dues").val(response.balance);
                    }
                },
            });
        });

        $('.payment-preview').on('click', function() {
            $.ajax({
                url: '/payments/' + $(this).attr('data-id') + '/preview',
                type: "GET",
                success: function(response) {
                    $(".modal-body").html(response);
                    $("#money-receipt-modal").modal("show");
                }
            });
        });
    });
};
