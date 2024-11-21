<?php
/*
 * Project: VbCalendar/Calendar
 * File: /CalendarInterface.php
 * File Created: 2024-11-07, 13:22:35
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-21, 21:21:26
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Calendar;


interface CalendarInterface {
    public function getYear(): int;
    public function setYear(int $year): void;
    public function getMonth(): int;
    public function setMonth(int $month): void;
    public function getDay(): int;
    public function setDay(int $day): void;
    public function getDays(): array;
}
