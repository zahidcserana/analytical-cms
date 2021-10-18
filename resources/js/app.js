require('./bootstrap');

require('alpinejs');

$('.my-date-picker').datepicker({
    language: 'en',
    autoClose: true,
    dateFormat: 'yyyy-mm-dd',
});