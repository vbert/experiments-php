<?php
/*
 * Project: Vbert\VbertCalendar/Calendar
 * File: /HorizontalMonthlyCalendar.php
 * File Created: 2024-10-28, 10:19:31
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-28, 23:14:05
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace Vbert\VbertCalendar\Calendar;

use DateTime;
use DatePeriod;
use DateInterval;

use Vbert\VbertCalendar\Constans\CalendarConstansInterface;
use Vbert\VbertCalendar\Calendar\CalendarInterface;


class HorizontalMonthlyCalendar implements CalendarInterface {
    private $constans;
    private $requestedMonth;


    public function __construct(CalendarConstansInterface $constans, $requestedMonth = null) {
        $this->constans = $constans;
        $this->requestedMonth = $requestedMonth ?: date('Y-m');
    }

    public function calculatePeriod() {
        $firstDayOfMonth = new DateTime("{$this->requestedMonth}-01");
        $lastDayOfMonth = (clone $firstDayOfMonth)->modify('last day of this month');
        $daysInMonth = $lastDayOfMonth->format('t');
        $period = new DatePeriod($firstDayOfMonth, new DateInterval('P1D'), $lastDayOfMonth->modify('+1 day'));

        $calendar = [];

        foreach ($period as $date) {
            $calendar[] = $date;
        }

        return [
            'firstDayOfMonth' => $firstDayOfMonth,
            'lastDayOfMonth' => $lastDayOfMonth,
            'daysInMonth' => $daysInMonth,
            'period' => $period,
            'calendar' => $calendar
        ];
    }

    public function generate() {

        var_dump([
            'constans' => $this->constans,
            'NAME_SHORT' => $this->constans::NAME_SHORT,
            'Monday' => $this->constans::dayName($this->constans::DAY_MONDAY, $this->constans::NAME_FULL),
        ]);

        return '';
    }
}
