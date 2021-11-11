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
});

