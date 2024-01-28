@component('mail::message')
# Hi {{ ENV('APP_NAME') }},

Here is the Database backup. Please keep it safe for future use.

Thanks,<br>
{{ Config::get('settings.client.name') }}<br>
{{ Config::get('settings.client.mobile') }} <br>
Powered by: <a href="{{ Config::get('settings.company.website') }}" target="_blank"><i class="fa fa-copyright" aria-hidden="true">{{ Config::get('settings.company.title') }}</i></a>
@endcomponent
