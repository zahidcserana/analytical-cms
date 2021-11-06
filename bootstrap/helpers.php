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
