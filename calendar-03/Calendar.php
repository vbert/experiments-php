<?php
/*
 * Project: calendar-03
 * File: /Calendar.php
 * File Created: 2024-06-14, 11:35:16
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-06-14, 15:40:49
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

class Calendar {

    const DAY_MONDAY = 1;
    const DAY_TUESDAY = 2;
    const DAY_WEDNESDAY = 3;
    const DAY_THURSDAY = 4;
    const DAY_FRIDAY = 5;
    const DAY_SATURDAY = 6;
    const DAY_SUNDAY = 7;
    const NAME_VARIANT_SHORT = 'short';
    const NAME_VARIANT_FULL = 'full';

    static $daysNames = [
        'full' => [
            self::DAY_MONDAY => 'Poniedziałek',
            self::DAY_TUESDAY => 'Wtorek',
            self::DAY_WEDNESDAY => 'Środa',
            self::DAY_THURSDAY => 'Czwartek',
            self::DAY_FRIDAY => 'Piątek',
            self::DAY_SATURDAY => 'Sobota',
            self::DAY_SUNDAY => 'Niedziela',
        ],
        'short' => [
            self::DAY_MONDAY => 'Pon',
            self::DAY_TUESDAY => 'Wto',
            self::DAY_WEDNESDAY => 'Śro',
            self::DAY_THURSDAY => 'Czw',
            self::DAY_FRIDAY => 'Pią',
            self::DAY_SATURDAY => 'Sob',
            self::DAY_SUNDAY => 'Nie',  
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

    private $activeYear;
    private $activeMonth;
    private $activeDay;
    private $firstDayOfWeek;
    private $firstDayOfMonth;
    private $daysOfMonth;
    private $arrayMonth = [];
    private $events = [];

    public function __construct($date=null, $firstDayOfWeek=self::DAY_MONDAY) {
        $this->activeYear = is_null($date)? date('Y') : date('Y', strtotime($date));
        $this->activeMonth = is_null($date)? date('m') : date('m', strtotime($date));
        $this->activeDay = is_null($date)? date('d') : date('d', strtotime($date));
        $this->firstDayOfWeek = $firstDayOfWeek;
        $this->firstDayOfMonth = $this->getFirstDayOfMonth();
        $this->daysOfMonth = $this->getDaysOfMonth();
        $this->arrayMonth['headerWeeks'] = $this->setHeaderWeeks();
        $this->arrayMonth['calendarWeeks'] = $this->setCalendarWeeks();
    }

    public function getFirstDayOfMonth($date=null) {
        if (is_null($date)) {
            return date('N', strtotime($this->activeYear . '-' . $this->activeMonth . '-1'));
        } else {
            return date('N', strtotime($date));
        }
    }

    public function getDaysOfMonth($date=null) {
        if (is_null($date)) {
            return cal_days_in_month(CAL_GREGORIAN, $this->activeMonth, $this->activeYear);
        } else {
            return cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
        }
    }

    public function getArrayMonth() {
        return $this->arrayMonth;
    }

    private function setHeaderWeeks($nameVariant=self::NAME_VARIANT_SHORT) {
        $orderDays = self::$orderDaysOfWeek[$this->firstDayOfWeek];
        $headerWeeks = [];
        foreach ($orderDays as $day) {
            $headerWeeks[] = self::$daysNames[$nameVariant][$day];
        }
        return $headerWeeks;
    }

    private function setCalendarWeeks() {
        $orderDays = self::$orderDaysOfWeek[$this->firstDayOfWeek];
        $calendarWeeks = [];
        $column = 0;
        $dayOfMonth = 1;
        $empty = true;
        // $firstDayOfMonth;
        // $daysOfMonth;
        while ($dayOfMonth <= $this->daysOfMonth) {
            foreach ($orderDays as $day) {
                if ($day < $this->firstDayOfMonth && $empty && $column < 7) {
                    $calendarWeeks[$column][] = null;
                } else if (condition) {
                    # code...
                }
                $dayOfMonth++;
                $column++;
            }
        }
        return $calendarWeeks;
    }
}


class CalendarOld {

    private $active_year, $active_month, $active_day;
    private $events = [];

    public function __construct($date = null) {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }

    public function add_event($txt, $date, $days = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }

    public function __toString() {
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));

var_dump([
    '$num_days' => $num_days,
    '$num_days_last_month' => $num_days_last_month
]);

        // Get first day of week
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);

        // $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        // $first_day_of_week = mktime(0, 0, 0, $this->active_month, 7, $this->active_year);
        
        var_dump([
            'date' => $this->active_year . '-' . $this->active_month . '-1',
            'timestamp' => strtotime($this->active_year . '-' . $this->active_month . '-1'),
            'format' => date('D N', strtotime($this->active_year . '-' . $this->active_month . '-1')),
            'first_day_of_week' => $first_day_of_week
        ]);
        
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            if ($i === $this->active_day) {
                $selected = ' selected';
            }
            $html .= '<div class="day_num' . $selected . '">';
            $html .= '<span>' . $i . '</span>';
            foreach ($this->events as $event) {
                for ($d = 0; $d <= ($event[2]-1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
                        $html .= '<div class="event' . $event[3] . '">';
                        $html .= $event[0];
                        $html .= '</div>';
                    }
                }
            }
            $html .= '</div>';
        }
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}