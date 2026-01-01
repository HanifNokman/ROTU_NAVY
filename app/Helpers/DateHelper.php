<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Standard date format: dd/mm/yyyy
     */
    const DATE_FORMAT = 'd/m/Y';

    /**
     * Standard datetime format: dd/mm/yyyy HH:mm
     */
    const DATETIME_FORMAT = 'd/m/Y H:i';

    /**
     * Standard time format: HH:mm (24-hour)
     */
    const TIME_FORMAT = 'H:i';

    /**
     * Database date format (for storage)
     */
    const DB_DATE_FORMAT = 'Y-m-d';

    /**
     * Database datetime format (for storage)
     */
    const DB_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Format a date to dd/mm/yyyy
     *
     * @param mixed $date Carbon instance, datetime string, or null
     * @param string|null $default Default value if date is null
     * @return string|null
     */
    public static function formatDate($date, ?string $default = null): ?string
    {
        if (!$date) {
            return $default;
        }

        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }

        return $date->format(self::DATE_FORMAT);
    }

    /**
     * Format a datetime to dd/mm/yyyy HH:mm
     *
     * @param mixed $datetime Carbon instance, datetime string, or null
     * @param string|null $default Default value if datetime is null
     * @return string|null
     */
    public static function formatDateTime($datetime, ?string $default = null): ?string
    {
        if (!$datetime) {
            return $default;
        }

        if (!$datetime instanceof Carbon) {
            $datetime = Carbon::parse($datetime);
        }

        return $datetime->format(self::DATETIME_FORMAT);
    }

    /**
     * Format time only to HH:mm (24-hour)
     *
     * @param mixed $time Carbon instance, datetime string, or null
     * @param string|null $default Default value if time is null
     * @return string|null
     */
    public static function formatTime($time, ?string $default = null): ?string
    {
        if (!$time) {
            return $default;
        }

        if (!$time instanceof Carbon) {
            $time = Carbon::parse($time);
        }

        return $time->format(self::TIME_FORMAT);
    }

    /**
     * Parse a dd/mm/yyyy date string to Carbon instance
     *
     * @param string $dateString Date string in dd/mm/yyyy format
     * @return Carbon|null
     */
    public static function parseDate(?string $dateString): ?Carbon
    {
        if (!$dateString) {
            return null;
        }

        try {
            return Carbon::createFromFormat(self::DATE_FORMAT, $dateString);
        } catch (\Exception $e) {
            // If parsing fails, try standard parse
            return Carbon::parse($dateString);
        }
    }

    /**
     * Convert dd/mm/yyyy to database format (YYYY-MM-DD)
     *
     * @param string $dateString Date string in dd/mm/yyyy format
     * @return string|null
     */
    public static function toDbFormat(?string $dateString): ?string
    {
        if (!$dateString) {
            return null;
        }

        $date = self::parseDate($dateString);
        return $date ? $date->format(self::DB_DATE_FORMAT) : null;
    }

    /**
     * Get date range display (handles same day vs multi-day)
     *
     * @param Carbon $startDate
     * @param Carbon|null $endDate
     * @return string
     */
    public static function formatDateRange(Carbon $startDate, ?Carbon $endDate = null): string
    {
        if (!$endDate || $startDate->toDateString() === $endDate->toDateString()) {
            return self::formatDate($startDate);
        }

        return self::formatDate($startDate) . ' - ' . self::formatDate($endDate);
    }

    /**
     * Get datetime range display
     *
     * @param Carbon $startDateTime
     * @param Carbon|null $endDateTime
     * @return string
     */
    public static function formatDateTimeRange(Carbon $startDateTime, ?Carbon $endDateTime = null): string
    {
        if (!$endDateTime) {
            return self::formatDateTime($startDateTime);
        }

        // If same day, show: dd/mm/yyyy HH:mm - HH:mm
        if ($startDateTime->toDateString() === $endDateTime->toDateString()) {
            return self::formatDate($startDateTime) . ' ' .
                   self::formatTime($startDateTime) . ' - ' .
                   self::formatTime($endDateTime);
        }

        // If different days, show: dd/mm/yyyy HH:mm - dd/mm/yyyy HH:mm
        return self::formatDateTime($startDateTime) . ' - ' . self::formatDateTime($endDateTime);
    }
}
