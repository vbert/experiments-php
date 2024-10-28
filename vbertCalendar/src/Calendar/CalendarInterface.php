<?php
/*
 * Project: Vbert\VbertCalendar/Calendar
 * File: /CalendarInterface.php
 * File Created: 2024-10-28, 10:14:22
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-28, 21:44:21
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace Vbert\VbertCalendar\Calendar;

interface CalendarInterface {
    public function calculatePeriod();
    public function generate();
}
