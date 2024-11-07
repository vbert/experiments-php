<?php
/*
 * Project: VbCalendar/Calendar
 * File: /CalendarDay.php
 * File Created: 2024-11-07, 0:21:51
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 10:39:14
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Calendar;

use DateTime;

use Vbert\VbCalendar\Constans\CalendarLangInterface;


/**
 * Value object of CalendarDay
 * @package Vbert\VbCalendar\Calendar
 */
class CalendarDay {
    private int $year;
    private int $month;
    private int $day;
    private string $dateString;
    private string $dayName;
    private int $dayWeekNumber;
    private int $dateTimestamp;
    private ?CalendarLangInterface $lang;

    public function __construct(int $year, int $month, int $day, CalendarLangInterface $lang=null) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->lang = $lang;

        $this->dateString = "$year-$month-$day";
        $this->dateTimestamp = strtotime($this->dateString);
        $this->dayWeekNumber = (int) date('N', $this->dateTimestamp);

        $this->dayName = $this->lang !== null 
            ? $this->lang->getDayName($this->dayWeekNumber, $this->lang::NAME_SHORT) 
            : date('D', $this->dateTimestamp);
    }

    public function getDate(): string {
        return $this->dateString;
    }

    public function getDayName(): string {
        return $this->dayName;
    }

    public function isWeekend(): bool {
        return in_array($this->dayWeekNumber, [6, 7]);
    }

    public function isToday(): bool {
        $today = new DateTime();
        // not 'Y-m-d'
        return $today->format('Y-n-j') === $this->dateString;
    }
}
