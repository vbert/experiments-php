<?php
/*
 * Project: Vbert\VbertCalendar/Constans
 * File: /CalendarLangPL.php
 * File Created: 2024-10-28, 10:05:27
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-28, 14:05:41
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace Vbert\VbertCalendar\Constans;

use Vbert\VbertCalendar\Constans\CalendarConstansInterface;

class CalendarLangPL implements CalendarConstansInterface {

    static $daysNames = [
        self::NAME_FULL => [
            self::DAY_MONDAY => 'Poniedziałek',
            self::DAY_TUESDAY => 'Wtorek',
            self::DAY_WEDNESDAY => 'Środa',
            self::DAY_THURSDAY => 'Czwartek',
            self::DAY_FRIDAY => 'Piątek',
            self::DAY_SATURDAY => 'Sobota',
            self::DAY_SUNDAY => 'Niedziela',
        ],
        self::NAME_SHORT => [
            self::DAY_MONDAY => 'Pon',
            self::DAY_TUESDAY => 'Wto',
            self::DAY_WEDNESDAY => 'Śro',
            self::DAY_THURSDAY => 'Czw',
            self::DAY_FRIDAY => 'Pią',
            self::DAY_SATURDAY => 'Sob',
            self::DAY_SUNDAY => 'Nie',  
        ]
    ];
    static $monthsNames = [
        self::NAME_FULL => [
            self::MONTH_JANUARY => 'Styczeń',
            self::MONTH_FEBRUARY => 'Luty',
            self::MONTH_MARCH => 'Marzec',
            self::MONTH_APRIL => 'Kwiecień',
            self::MONTH_MAY => 'Maj',
            self::MONTH_JUNE => 'Czerwiec',
            self::MONTH_JULY => 'Lipiec',
            self::MONTH_AUGUST => 'Sierpień',
            self::MONTH_SEPTEMBER => 'Wrzesień',
            self::MONTH_OCTOBER => 'Październik',
            self::MONTH_NOVEMBER => 'Listopad',
            self::MONTH_DECEMBER => 'Grudzień'
        ],
        self::NAME_SHORT => [
            self::MONTH_JANUARY => 'Sty',
            self::MONTH_FEBRUARY => 'Lut',
            self::MONTH_MARCH => 'Mar',
            self::MONTH_APRIL => 'Kwi',
            self::MONTH_MAY => 'Maj',
            self::MONTH_JUNE => 'Cze',
            self::MONTH_JULY => 'Lip',
            self::MONTH_AUGUST => 'Sie',
            self::MONTH_SEPTEMBER => 'Wrz',
            self::MONTH_OCTOBER => 'Paź',
            self::MONTH_NOVEMBER => 'Lis',
            self::MONTH_DECEMBER => 'Gru'
        ]
    ];

    static $orderDaysOfWeek = [
        self::DAY_MONDAY => [
            self::DAY_MONDAY,
            self::DAY_TUESDAY,
            self::DAY_WEDNESDAY,
            self::DAY_THURSDAY,
            self::DAY_FRIDAY,
            self::DAY_SATURDAY,
            self::DAY_SUNDAY
        ],
        self::DAY_SUNDAY => [
            self::DAY_SUNDAY,
            self::DAY_MONDAY,
            self::DAY_TUESDAY,
            self::DAY_WEDNESDAY,
            self::DAY_THURSDAY,
            self::DAY_FRIDAY,
            self::DAY_SATURDAY
        ]
    ];

    static function dayName($dayNumber, $nameVariant=self::NAME_SHORT) {
        return self::$daysNames[$nameVariant][$dayNumber];
    }

    static function monthName($monthNumber, $nameVariant=self::NAME_SHORT) {
        return self::$monthsNames[$nameVariant][$monthNumber];
    }
}
