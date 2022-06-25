@component('mail::message')
# Hi {{ $customer->name }},

Thank you for being with us. Your invoice statement is attached below.

Thanks,<br>
{{ Config::get('settings.client.name') }}<br>
{{ Config::get('settings.client.mobile') }} <br>
Powered by: <a href="{{ Config::get('settings.company.website') }}" target="_blank"><i class="fa fa-copyright" aria-hidden="true">{{ ENV('APP_NAME') }}</i></a>
@endcomponent
