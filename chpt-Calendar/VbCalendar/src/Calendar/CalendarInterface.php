<?php
/*
 * Project: VbCalendar/Calendar
 * File: /CalendarInterface.php
 * File Created: 2024-11-07, 13:22:35
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 13:46:18
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Calendar;


interface CalendarInterface {
    public function getYear(): int;
    public function getMonth(): int;
    public function getDays(): array;
    public function setYear(int $year): void;
    public function setMonth(int $month): void;
}
