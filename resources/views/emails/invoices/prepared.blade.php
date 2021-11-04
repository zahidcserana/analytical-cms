@component('mail::message')
# Hi {{ $invoice->customer->name }},

Thank you for your transaction. Your invoice is attached below.

Thanks,<br>
{{ Config::get('settings.company.name') }}<br>
{{ Config::get('settings.company.mobile') }}
@endcomponent
