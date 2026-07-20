<?php

namespace App\Utils;

class Angka
{
    public static function format($value, int $decimals = 2): string
    {
        if ($value === null || $value === '') {
            return $value;
        }
        return number_format((float) $value, $decimals, '.', ',');
    }

    public static function parseInt($value): int
    {
        $clean = preg_replace('/[^0-9.]/', '', (string) $value);
        return (int) $clean;
    }

    public static function parseFloat($value): float
    {
        $clean = preg_replace('/[^0-9.]/', '', (string) $value);
        return (float) $clean;
    }
}
