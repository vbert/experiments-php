<?php
/*
 * Project: calendar-04
 * File: /Calendar.php
 * File Created: 2024-06-14, 20:01:27
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-16, 12:43:25
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

interface CalendarInterface {
    public function generate($year = null, $month = null, $day = null);
}

class Calendar implements CalendarInterface {
    private $year;
    private $month;

    public function __construct($year = null, $month = null, $day = null) {
        $this->year = $year ? (int) $year : (int) date('Y');
        $this->month = $month ? (int) $month : (int) date('m');
        $this->day = $day ? (int) $day : (int) date('d');
    }

    public function generate($year = null, $month = null, $day = null) {
        $year = $year ? $year : $this->year;
        $month = $month ? $month : $this->month;

        $firstDayOfMonth = new DateTime("$year-$month-01");
        $daysInMonth = $firstDayOfMonth->format('t');

        $firstDayOfWeek = (clone $firstDayOfMonth)->modify('last monday');
        $lastDayOfMonth = (clone $firstDayOfMonth)->modify('last day of this month');
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

class EventType {
    private $type;
    private $color;

    public function __construct($type, $color) {
        $this->type = $type;
        $this->color = $color;
    }

    public function getType() {
        return $this->type;
    }

    public function getColor() {
        return $this->color;
    }
}

class CalendarRenderer {
    private $calendar;
    private $events;
    private $baseUrl;

    public function __construct(CalendarInterface $calendar, $events = array(), $baseUrl = '') {
        $this->calendar = $calendar;
        $this->events = $events;
        $this->baseUrl = $baseUrl;
    }

    public function render($year = null, $month = null) {
        $calendar = $this->calendar->generate($year, $month);
        $output = '<div class="calendar">';
        $output .= '<div class="calendar-row calendar-header">';
        $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        foreach ($daysOfWeek as $day) {
            $output .= '<div class="calendar-cell">' . $day . '</div>';
        }
        $output .= '</div>';

        foreach ($calendar as $week) {
            $output .= '<div class="calendar-row">';
            for ($day = 1; $day <= 7; $day++) {
                $output .= '<div class="calendar-cell">';
                foreach ($week as $date) {
                    if ($date->format('N') == $day) {
                        $class = '';
                        if ($date->format('m') != $month) {
                            $class = 'other-month';
                        }
                        $link = $this->baseUrl . '?year=' . $date->format('Y') . '&month=' . $date->format('m') . '&day=' . $date->format('d');
                        $output .= '<a href="' . $link . '" class="day-number ' . $class . '">' . $date->format('j') . '</a>';
                        $eventKey = $date->format('Y-m-d');
                        if (isset($this->events[$eventKey])) {
                            foreach ($this->events[$eventKey] as $event) {
                                $color = htmlspecialchars($event->getColor());
                                $output .= '<div class="event" style="background-color:' . $color . ';">' . htmlspecialchars($event->getType()) . '</div>';
                            }
                        }
                    }
                }
                $output .= '</div>';
            }
            $output .= '</div>';
        }

        $output .= '</div>';
        return $output;
    }
}
