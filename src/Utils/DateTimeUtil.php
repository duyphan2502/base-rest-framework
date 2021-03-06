<?php

namespace Si6\Base\Utils;

use Exception;
use Illuminate\Support\Carbon;

trait DateTimeUtil
{
    /**
     * @param $value
     * @param string $oldFormat
     * @return Carbon|string
     */
    public function getDateString($value, $oldFormat = 'Ymd')
    {
        /** @var Carbon $date */
        $date = $this->createFromFormat($oldFormat, $value);

        return $date ? $date->toDateString() : $date;
    }

    /**
     * @param string $format
     * @param $time
     * @param null $timezone
     * @return \Carbon\Carbon|null
     */
    public function createFromFormat(string $format, $time, $timezone = null)
    {
        try {
            return Carbon::createFromFormat($format, $time, $timezone);
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @param string $date
     * @param null $toTz
     * @return array|null
     */
    public function convertDateToRangeWithTimezone(string $date, $toTz = null)
    {
        $toTz = $toTz ?: 'Asia/Tokyo';

        $date = $this->createFromFormat('Y-m-d', $date, $toTz);

        if (!$date) {
            return null;
        }

        $start = $date->copy()->startOfDay();
        $end   = $date->copy()->endOfDay();

        $start->setTimezone('UTC');
        $end->setTimezone('UTC');

        return [$start, $end];
    }
}
