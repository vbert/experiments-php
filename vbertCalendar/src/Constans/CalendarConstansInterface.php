<?php
/*
 * Project: Vbert\VbertCalendar/Constans
 * File: /CalendarConstansInterface.php
 * File Created: 2024-10-28, 9:47:13
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-28, 14:05:41
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace Vbert\VbertCalendar\Constans;

interface CalendarConstansInterface {
    const DAY_MONDAY = 1;
    const DAY_TUESDAY = 2;
    const DAY_WEDNESDAY = 3;
    const DAY_THURSDAY = 4;
    const DAY_FRIDAY = 5;
    const DAY_SATURDAY = 6;
    const DAY_SUNDAY = 7;
    const MONTH_JANUARY = 1;
    const MONTH_FEBRUARY = 2;
    const MONTH_MARCH = 3;
    const MONTH_APRIL = 4;
    const MONTH_MAY = 5;
    const MONTH_JUNE = 6;
    const MONTH_JULY = 7;
    const MONTH_AUGUST = 8;
    const MONTH_SEPTEMBER = 9;
    const MONTH_OCTOBER = 10;
    const MONTH_NOVEMBER = 11;
    const MONTH_DECEMBER = 12;
    const NAME_SHORT = 'short';
    const NAME_FULL = 'full';

    static function dayName($dayNumber, $nameVariant=self::NAME_SHORT);
    static function monthName($monthNumber, $nameVariant=self::NAME_SHORT);
}