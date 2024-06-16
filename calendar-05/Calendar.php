<?php
/*
 * Project: calendar-05
 * File: /Calendar.php
 * File Created: 2024-06-15, 21:20:55
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-06-15, 21:21:16
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

interface CalendarInterface {
    public function generate($year = null, $month = null, $day = null);
}

class MonthlyCalendar implements CalendarInterface {
    private $year;
    private $month;

    public function __construct($year = null, $month = null) {
        $this->year = $year ? $year : date('Y');
        $this->month = $month ? $month : date('m');
    }

    public function generate($year = null, $month = null, $day = null) {
        $year = $year ? $year : $this->year;
        $month = $month ? $month : $this->month;

        $firstDayOfMonth = new DateTime("$year-$month-01");
        $daysInMonth = $firstDayOfMonth->format('t');

        $firstDayOfWeek = (clone $firstDayOfMonth)->modify('last monday');
        $lastDayOfMonth = (clone $firstDayOfMonth)->modify("last day of this month");
        $lastDayOfWeek = (clone $lastDayOfMonth)->modify('next sunday');

        $calendar = [];
        $period = new DatePeriod($firstDayOfWeek, new DateInterval('P1D'), $lastDayOfWeek->modify('+1 day'));

        foreach ($period as $date) {
            $week = (int)$date->format('W');
            $calendar[$week][] = $date;
        }

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

    public function generate($year = null, $month = null, $day = null) {
        $year = $year ? $year : $this->year;
        $month = $month ? $month : $this->month;
        $day = $day ? $day : $this->day;

        $currentDay = new DateTime("$year-$month-$day");
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

    public function generate($year = null, $month = null, $day = null) {
        $year = $year ? $year : $this->year;

        $calendar = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDayOfMonth = new DateTime("$year-$month-01");
            $daysInMonth = $firstDayOfMonth->format('t');
            $monthDays = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = new DateTime("$year-$month-$day");
                $monthDays[] = $date;
            }

            $calendar[$month] = $monthDays;
        }

        return $calendar;
    }
}
