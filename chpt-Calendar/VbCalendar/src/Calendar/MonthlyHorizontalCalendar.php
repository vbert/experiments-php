<?php
/*
 * Project: VbCalendar/Calendar
 * File: /MonthlyHorizontalCalendar.php
 * File Created: 2024-11-07, 13:28:34
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-24, 17:34:59
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Calendar;

use Vbert\VbCalendar\Constans\CalendarLangInterface;
use Vbert\VbCalendar\Calendar\CalendarInterface;


/**
 * Class MonthlyHorizontalCalendar
 * @package Vbert\VbCalendar\Calendar
 */
class MonthlyHorizontalCalendar implements CalendarInterface {
    private int $year;
    private int $month;
    private int $day;
    private array $days;
    private ?CalendarLangInterface $lang;

    /**
     * MonthlyHorizontalCalendar constructor.
     * @param int $year
     * @param int $month
     * @param CalendarLangInterface|null $lang
     * @return void
     */
    public function __construct(int $year, int $month, CalendarLangInterface $lang=null) {
        $this->year = $year;
        $this->month = $month;
        $this->lang = $lang;
        $this->initializeDays();
    }

    public function getYear(): int {
        return $this->year;
    }

    public function setYear(int $year): void {
        $this->year = $year;
        $this->initializeDays();
    }

    public function getMonth(): int {
        return $this->month;
    }

    public function setMonth(int $month): void {
        $this->month = $month;
        $this->initializeDays();
    }

    public function getDay(): int {
        return $this->day;
    }

    public function setDay(int $day): void {
        $this->day = $day;
    }

    public function getDays(): array {
        return $this->days;
    }

    private function initializeDays(): void {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $this->days[] = new CalendarDay($this->year, $this->month, $day, $this->lang);
        }
    }
}
