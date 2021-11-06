@component('mail::message')
# Hi {{ $customer->name }},

Thank you for being with us. Your invoice statement is attached below.

Thanks,<br>
{{ Config::get('settings.company.name') }}<br>
{{ Config::get('settings.company.mobile') }}
@endcomponent
