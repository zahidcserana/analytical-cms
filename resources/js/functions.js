$(document).ready(function() {
    window.dateTimePicker = function () {
        $('.date-time-picker').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            locale: {
                format: 'Y-MM-DD HH:mm:ss'
            }
        });
    };

    window.datePicker = function () {
        $('.my-date-picker').datepicker({
            language: 'en',
            autoClose: true,
            dateFormat: 'yyyy-mm-dd',
        });
    };

    window.ajaxMessageBox = function (message, success) {
        let time = 2000

        if (success) {
            $('.ajax-success').html(message).show()

            setTimeout(function() {$('.ajax-success').hide()
            }, time)
        } else {
            $('.ajax-error').html(message).show()

            setTimeout(function() {$('.ajax-error').hide()
            }, time)
        }
    }

    window.customerSelect2 = function () {
        $('.customer-select2').select2({
            theme: "classic",
            placeholder: 'Select Customer',
            ajax: {
                url: '/customers/ajax-search',
                dataType: 'json',
                delay: 250,
                cache: true
            }
        });

        let customerId = $(".customer-select2").attr("data-customer-id");
        // let customerId = <?php echo json_decode($_GET['customer_id'] ?? 0, true)?>;

        if (customerId != null && customerId != '') {
            // var data = JSON.parse(customer);
            $.ajax({
                url: '/customers/ajax-search-by-id/' + customerId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    var newOption = new Option(data.name, data.id, false, false);
                    $('.customer-select2').append(newOption).trigger('change');
                }
            });

        }
    };
});

