<?php

namespace App\Helpers;

class Currency
{
    public static function format(float $amount): string
    {
        $locale = app()->getLocale();
        $code = config('app.currency', 'VND');

        if ($code === 'VND') {
            return number_format($amount, 0, ',', '.') . ' ₫';
        }

        $symbol = $code === 'USD' ? '$' : $code;
        return $symbol . number_format($amount, 2, '.', ',');
    }
}
