<?php
/*
 * Project: Calendar
 * File: /CalendarRendererInterface.php
 * File Created: 2024-11-24, 11:33:05
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-24, 11:44:50
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Calendar;


interface CalendarRendererInterface {
    public function render(): string;
}
