$(document).ready(function() {
    window.checkDeleteButton = function (){
        $('.order-item-fields:not(.order-item-deleted)').length === 1 ? $('.delete-item').prop('disabled', true) : $('.delete-item').prop('disabled', false);
        $('.order-item-fields:not(.order-item-deleted)').length === 1 ? $('.remove-item').prop('disabled', true) : $('.remove-item').prop('disabled', false);
    };

    window.hideItems = function () {
        if(!$('[name="order_id"]').val()) {
            $('#item_container, #add_item').hide();
        }
    };

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
        $('.date-picker').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'Y-MM-DD'
            }
        });
    };

    window.deleteItemFromTableButton = function () {
        $(document).on('click', '.delete-item', function (event) {
            $(this).parent().parent().find('.reset_on_delete').val(0);
            $(this).parent().parent().hide().addClass('order-item-deleted');
            checkDeleteButton();
            event.preventDefault();
        });
    }

    window.removeItemFromTableButton = function () {
        $(document).on('click', '.remove-item', function (event) {
            $(this).parent().parent().remove();
            checkDeleteButton();
            event.preventDefault();
        });
    }

    window.debounce = function (func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    window.getCustomerConfig = function () {
        function getCurrencyAndUnit(customerId) {
            if (customerId > 0) {
                $.get('/customer-currency-unit/' + customerId, function(data) {
                    if (data.weight_unit != null) {
                        $('label[for*="input-weight"] span').text(' (' + data.weight_unit + ') ');
                    }

                    if (data.currency_code != null) {
                        $('th[for*="th-currency"] span').text(' (' + data.currency_code + ') ');
                        $('label[for*="input-price"] span').text(' (' + data.currency_code + ') ');
                        $('label[for*="input-replacement_value"] span').text(' (' + data.currency_code + ') ');
                        $('label[for*="input-customs_price"] span').text(' (' + data.currency_code + ') ');
                        $('label[for*="input-discount_amount"] span').text(' (' + data.currency_code + ') ');
                        $('.overview-subtotal b').text(data.currency_code);
                        $('.overview-shipping b').text(data.currency_code);
                        $('.overview-discount b').text(data.currency_code);
                        $('.overview-total b').text(data.currency_code);
                    }

                    if (data.dimensions_unit != null) {
                        $('label[for*="input-width"] span').text(' (' + data.dimensions_unit + ') ');
                        $('label[for*="input-height"] span').text(' (' + data.dimensions_unit + ') ');
                        $('label[for*="input-length"] span').text(' (' + data.dimensions_unit + ') ');
                    }
                });
            }
        }

        let customerSelect = $('.customer_id');

        customerSelect.on('change', function (event) {
            let customerId = customerSelect.val();
            getCurrencyAndUnit(customerId);
        }).trigger('change');
    }

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

window.dataExportableColumn = function () {
    let selectAll = false;

    $('#btn-all-column').click(function(event) {
        if(!this.selectAll) {
            this.selectAll = true;
            $(this).addClass('active');
            $(this).attr('aria-pressed', true);

            $('#exprtable-column-list :checkbox').each(function() {
                this.checked = true;
            });
        } else {
            this.selectAll = false;
            $(this).removeClass('active');
            $(this).attr('aria-pressed', false);

            $('#exprtable-column-list :checkbox').each(function() {
                this.checked = false;
            });
        }
    });
}
