<?php


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
