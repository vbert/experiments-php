<?php
/*
 * Project: Vbert\VbertCalendar/Calendar
 * File: /HorizontalMonthlyCalendar.php
 * File Created: 2024-10-28, 10:19:31
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-05, 23:38:12
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace Vbert\VbertCalendar\Calendar;

use DateTime;
use DatePeriod;
use DateInterval;

use Vbert\VbertCalendar\Constans\CalendarLangInterface;
use Vbert\VbertCalendar\Calendar\CalendarInterface;


class HorizontalMonthlyCalendar implements CalendarInterface {
    private $lang;
    private $requestedMonth;


    public function __construct(CalendarLangInterface $lang, $requestedMonth = null) {
        $this->lang = $lang;
        $this->requestedMonth = $requestedMonth ?: date('Y-n');
    }

    public function calculatePeriod() {
        $firstDayOfMonth = new DateTime("{$this->requestedMonth}-1");
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
            'requestedMonth' => $this->requestedMonth,
            'period' => $period,
            // [
            //     'start' => $period->getStartDate(),
            //     'end' => $period->getEndDate(),
            //     'interval' => $period->getDateInterval(),
            // ],

            'calendar' => $calendar
        ];
    }

    public function generate() {

        var_dump([
            'lang' => $this->lang,
            'NAME_SHORT' => $this->lang::NAME_SHORT,
            'Monday' => $this->lang::dayName($this->lang::DAY_MONDAY, $this->lang::NAME_FULL),
        ]);

        return '';
    }
}
