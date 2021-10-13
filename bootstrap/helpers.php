<?php

use Carbon\Carbon;
use App\Models\UserSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;


if (!function_exists('status_class')) {
    function status_class($status)
    {
        $class = [
            'paid' => 'badge-success',
            'pending' => 'badge-secondary',
            'due' => 'badge-info',
        ];

        return $class[$status];
    }
}




// unnecessary
if (!function_exists('dot')) {
    function dot($key)
    {
        $key = str_replace(['[', ']'], ['.', ''], $key);

        return $key;
    }
}


if (!function_exists('dimension_unit')) {
    function dimension_unit($customer = null)
    {
        if (empty($customer))
            return null;

        return $customer->dimensions_unit;
    }
}

if (!function_exists('with_dimension_unit')) {
    function with_dimension_unit($customer, $number = null)
    {
        if (empty($number))
            return null;

        return $number . ' ' . dimension_unit($customer);
    }
}

if (!function_exists('weight_unit')) {
    function weight_unit($customer = null)
    {
        if (empty($customer))
            return null;

        return $customer->weight_unit;
    }
}

if (!function_exists('with_weight_unit')) {
    function with_weight_unit($customer, $number = null)
    {
        if (empty($number))
            return null;

        return $number . ' ' . weight_unit($customer);
    }
}

if (!function_exists('currency')) {
    function currency($customer = null)
    {
        if (empty($customer))
            return null;

        return $customer->currency_code;
    }
}

if (!function_exists('with_currency')) {
    function with_currency($customer, $number = null)
    {
        if (empty($number))
            return null;

        return $number . ' ' . currency($customer);
    }
}

if (!function_exists('label_format')) {
    function label_format($value = null)
    {
        if ($value)
            return ' (' . $value . ') ';
    }
}

if (!function_exists('current_page')) {
    function current_page($link = null, $parent = false)
    {
        $routes = [
            'home' => [
                route('home')
            ],
            'orders' => [
                route('orders.index'),
                route('orders.create'),
                route('shipments.index'),
                route('shipping_carriers.index'),
                route('shipping_methods.index')
            ],
            'products' => [
                route('products.index'),
                route('products.create')
            ],
            'returns' => [
                route('returns.index'),
                route('returns.create')
            ],
            'purchase_orders' => [
                route('purchase_orders.index'),
                route('purchase_orders.create'),
                route('vendors.index')
            ],
            'three_pls' => [
                route('three_pls.index'),
                route('three_pls.create'),
            ],
            'customers' => [
                route('customers.index'),
                route('customers.create'),
                route('users.index'),
                route('users.create')
            ],
            'billings' => [
                route('billings.customers'),
                route('billings.bills'),
                route('billings.billing_profiles'),
                route('billings.product_profiles'),
                route('billings.reconcile'),
                route('billings.exports'),
            ],
            'domains' => [
                route('domains.index'),
                route('domains.create'),
            ],
            'warehouses' => [
                route('warehouses.index')
            ],
            'locations' => [
                route('locations.index')
            ]
        ];

        $current = Request::url();
        $class = '';

        if ($parent) {
            foreach ($routes as $key => $route) {
                if ($key === $parent && in_array($current, $route)) {
                    $class = 'active';
                }
            }
        }

        if ($current === $link) {
            $class = 'active';
        }

        return $class;
    }
}

if (!function_exists('site_title')) {
    function site_title()
    {
        $domain = \App\Models\Domain::where('domain', app()->request->getHost())->first();

        if ($domain && $domain->title) {
            return $domain->title;
        }

        return config('app.name');
    }
}

if (!function_exists('site_favicon')) {
    function site_favicon()
    {
        $domain = \App\Models\Domain::where('domain', app()->request->getHost())->first();

        if ($domain && $domain->favicon) {
            return $domain->favicon->source;
        }

        return asset('argon') . '/img/brand/favicon.png';
    }
}

if (!function_exists('login_logo')) {
    function login_logo()
    {
        $domain = \App\Models\Domain::where('domain', app()->request->getHost())->first();

        if ($domain && $domain->logo) {
            return $domain->logo->source;
        }

        return asset('argon') . '/img/brand/logo.png';
    }
}

if (!function_exists('primary_color')) {
    function primary_color()
    {
        if (auth()->check()) {
            return auth()->user()->primary_color();
        }

        $domain = \App\Models\Domain::where('domain', app()->request->getHost())->first();

        if ($domain && $domain->primary_color) {
            return $domain->primary_color;
        }

        return env('DEFAULT_COLOR_PRIMARY');
    }
}

if (!function_exists('route_method')) {
    function route_method()
    {
        if (empty(Route::current())) {
            return '';
        }

        return Route::current()->methods()[0] ?? '';
    }
}

if (!function_exists('messaging_script')) {
    function messaging_script()
    {
        if (!auth()->user() || auth()->user()->isAdmin() || empty(session('customer_id'))) {
            return "";
        }

        return app()->messengerChat->render(
            auth()->user()->customers->find(session('customer_id')),
            auth()->user()
        );
    }
}

if (!function_exists('titles_and_fields')) {
    function titles_and_fields($data = [], $columns)
    {
        if (empty($data)) {
            return [Arr::pluck($columns, 'column'), Arr::pluck($columns, 'title')];
        }

        return [array_keys($data), array_values($data)];
    }
}

if (!function_exists('weight_unit_conversion'))
{
    function weight_unit_conversion($value, $defaultUnit = '', $requestedUnit = '')
    {
        $value = (float) $value;

        if ($defaultUnit == 'oz' && $requestedUnit == 'lb') {
            return $value / 16;
        }

        if ($defaultUnit == 'kg' && $requestedUnit == 'lb') {
            return $value / 0.45359237;
        }

        if ($defaultUnit == 'g' && $requestedUnit == 'lb') {
            return $value * 0.00220462;
        }

        if ($defaultUnit == 'oz' && $requestedUnit == 'g') {
            return $value * 453.59237;
        }

        if ($defaultUnit == 'lb' && $requestedUnit == 'g') {
            return $value / 0.035274;
        }

        if ($defaultUnit == 'kg' && $requestedUnit == 'g') {
            return $value * 1000;
        }

        if ($defaultUnit == 'lb' && $requestedUnit == 'oz') {
            return $value * 16;
        }

        if ($defaultUnit == 'kg' && $requestedUnit == 'oz') {
            return $value / 0.02834952;
        }

        if ($defaultUnit == 'g' && $requestedUnit == 'oz') {
            return $value / 0.03527396195;
        }

        if ($defaultUnit == 'lb' && $requestedUnit == 'kg') {
            return $value * 0.45359237;
        }

        if ($defaultUnit == 'oz' && $requestedUnit == 'kg') {
            return $value * 0.02834952;
        }

        if ($defaultUnit == 'g' && $requestedUnit == 'kg') {
            return $value / 1000;
        }

        return $value;
    }
}

if (!function_exists('getConvertedProductWeight'))
{
    function get_converted_product_weight($productWeight)
    {
        $weightUnit = explode(' ', $productWeight);
        $weightUnit = end($weightUnit);

        return weight_unit_conversion((float) $productWeight, $weightUnit, env('DEFAULT_WEIGHT_UNIT'));
    }
}
