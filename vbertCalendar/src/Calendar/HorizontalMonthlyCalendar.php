<?php
/*
 * Project: Vbert\VbertCalendar/Calendar
 * File: /HorizontalMonthlyCalendar.php
 * File Created: 2024-10-28, 10:19:31
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-28, 14:05:41
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace Vbert\VbertCalendar\Calendar;

use Vbert\VbertCalendar\Constans\CalendarConstansInterface;
use Vbert\VbertCalendar\Calendar\CalendarInterface;

class HorizontalMonthlyCalendar implements CalendarInterface {
    private $constans;

    public function __construct(CalendarConstansInterface $constans) {
        $this->constans = $constans;
    }


    public function generate() {
        // TODO: Implement generate() method.

        var_dump([
            'constans' => $this->constans,
            'NAME_SHORT' => $this->constans::NAME_SHORT
        ]);

    }
}
