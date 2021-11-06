@component('mail::message')
# Hi {{ $invoice->customer->name }},

Thank you for being with us. Your invoice is attached below.

Thanks,<br>
{{ Config::get('settings.company.name') }}<br>
{{ Config::get('settings.company.mobile') }}
@endcomponent
