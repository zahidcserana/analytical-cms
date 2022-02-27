<?php


if (!function_exists('status_class')) {
    function status_class($status)
    {
        $class = [
            'paid' => 'badge-success',
            'pending' => 'badge-secondary',
            'due' => 'badge-info',
            'adjusted' => 'badge-info',
            'advanced' => 'badge-success',
            '0' => 'badge-secondary',
            '1' => 'badge-success',

        ];

        return $class[$status];
    }
}


if (!function_exists('word_amount')) {
    function word_amount($amount)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $digit->format((int)$amount);
    }
}

if (!function_exists('format_amount')) {
    function format_amount($amount)
    {
        $digit = new NumberFormatter("en", NumberFormatter::DEFAULT_STYLE);
        return $digit->format((int)$amount);
    }
}

if (!function_exists('format_amount_bn')) {
    function format_amount_bn($amount)
    {
        $digit = new NumberFormatter("en", NumberFormatter::DEFAULT_STYLE);
        return $digit->format((int)$amount);
    }
}

if (!function_exists('amount_with_symbol')) {
    function amount_with_symbol($amount)
    {
        return html_entity_decode('&#2547;') . ' ' . format_amount($amount);
    }
}

if (!function_exists('get_expense_type')) {
    function get_expense_type($expense_type)
    {
        return Arr::get(config('settings.expenseType'), $expense_type);
    }
}