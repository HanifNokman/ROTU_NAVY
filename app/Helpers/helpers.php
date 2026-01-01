<?php

use App\Helpers\DateHelper;
use Carbon\Carbon;

if (!function_exists('formatDate')) {
    /**
     * Format a date to dd/mm/yyyy
     *
     * @param mixed $date
     * @param string|null $default
     * @return string|null
     */
    function formatDate($date, ?string $default = null): ?string
    {
        return DateHelper::formatDate($date, $default);
    }
}

if (!function_exists('formatDateTime')) {
    /**
     * Format a datetime to dd/mm/yyyy HH:mm
     *
     * @param mixed $datetime
     * @param string|null $default
     * @return string|null
     */
    function formatDateTime($datetime, ?string $default = null): ?string
    {
        return DateHelper::formatDateTime($datetime, $default);
    }
}

if (!function_exists('formatTime')) {
    /**
     * Format time only to HH:mm (24-hour)
     *
     * @param mixed $time
     * @param string|null $default
     * @return string|null
     */
    function formatTime($time, ?string $default = null): ?string
    {
        return DateHelper::formatTime($time, $default);
    }
}

if (!function_exists('formatDateRange')) {
    /**
     * Get date range display (handles same day vs multi-day)
     *
     * @param Carbon $startDate
     * @param Carbon|null $endDate
     * @return string
     */
    function formatDateRange(Carbon $startDate, ?Carbon $endDate = null): string
    {
        return DateHelper::formatDateRange($startDate, $endDate);
    }
}

if (!function_exists('formatDateTimeRange')) {
    /**
     * Get datetime range display
     *
     * @param Carbon $startDateTime
     * @param Carbon|null $endDateTime
     * @return string
     */
    function formatDateTimeRange(Carbon $startDateTime, ?Carbon $endDateTime = null): string
    {
        return DateHelper::formatDateTimeRange($startDateTime, $endDateTime);
    }
}
