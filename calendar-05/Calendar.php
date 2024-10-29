<?php
/*
 * Project: calendar-05
 * File: /Calendar.php
 * File Created: 2024-06-15, 21:20:55
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-29, 9:00:40
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace vbert\experiments\calendar05;

use DateTime;
use DatePeriod;
use DateInterval;

interface CalendarInterface {
    public function generate();
}

class CalendarConstans {
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

class MonthlyCalendar implements CalendarInterface {
    private $year;
    private $month;

    public function __construct($year = null, $month = null) {
        $this->year = $year ? $year : date('Y');
        $this->month = $month ? $month : date('m');
    }

    public function generate() {
        $firstDayOfMonth = new DateTime("{$this->year}-{$this->month}-01");
        $daysInMonth = $firstDayOfMonth->format('t');

        $firstDayOfWeek = (clone $firstDayOfMonth)->modify('last monday');
        $lastDayOfMonth = (clone $firstDayOfMonth)->modify('last day of this month');
        $lastDayOfWeek = (clone $lastDayOfMonth)->modify('next sunday');

        $calendar = [];
        $period = new DatePeriod($firstDayOfWeek, new DateInterval('P1D'), $lastDayOfWeek->modify('+1 day'));

        foreach ($period as $date) {
            $week = (int)$date->format('W');
            $calendar[$week][] = $date;
            
            var_dump([
                'date' => $date,
                'week' => $week,
            ]);
            
        }

        var_dump([
            'year' => $this->year,
            'month' => $this->month,
            'daysInMonth' => $daysInMonth,
            'firstDayOfWeek' => $firstDayOfWeek,
            'lastDayOfWeek' => $lastDayOfWeek,
            'firstDayOfMonth' => $firstDayOfMonth,
            'lastDayOfMonth' => $lastDayOfMonth,
            'period' => $period,
            'calendar' => $calendar,
        ]);

        return $calendar;
    }
}

class WeeklyCalendar implements CalendarInterface {
    private $year;
    private $month;
    private $day;

    public function __construct($year = null, $month = null, $day = null) {
        $this->year = $year ? $year : date('Y');
        $this->month = $month ? $month : date('m');
        $this->day = $day ? $day : date('d');
    }

    public function generate() {
        $currentDay = new DateTime("{$this->year}-{$this->month}-{$this->day}");
        $startOfWeek = (clone $currentDay)->modify('last monday');
        $endOfWeek = (clone $currentDay)->modify('next sunday');

        $calendar = [];
        $period = new DatePeriod($startOfWeek, new DateInterval('P1D'), $endOfWeek->modify('+1 day'));

        foreach ($period as $date) {
            $calendar[] = $date;
        }

        return $calendar;
    }
}

class YearlyCalendar implements CalendarInterface {
    private $year;

    public function __construct($year = null) {
        $this->year = $year ? $year : date('Y');
    }

    public function generate() {
        $calendar = [];

        for ($month = 1; $month <= 12; $month++) {
            $firstDayOfMonth = new DateTime("{$this->year}-{$month}-01");
            $daysInMonth = $firstDayOfMonth->format('t');
            $monthDays = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = new DateTime("{$this->year}-{$month}-{$day}");
                $monthDays[] = $date;
            }

            $calendar[$month] = $monthDays;
        }

        return $calendar;
    }
}
