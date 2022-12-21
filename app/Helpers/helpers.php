<?php

if (!function_exists('formatDateDayIndo')) {
    function formatDateDayIndo($value)
    {
        // Rabu, 8 September 2021
        \Carbon\Carbon::setLocale('id');
        return \Carbon\Carbon::parse($value)->isoFormat('dddd, D MMMM Y');
    }
}
