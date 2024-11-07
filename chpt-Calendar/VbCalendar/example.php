<?php
/*
 * Project: VbCalendar
 * File: /example.php
 * File Created: 2024-11-07, 0:32:18
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 1:00:59
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
header('Content-type: text/html; charset=utf-8');
setlocale(LC_TIME, 'pl_PL.UTF8');
// Ustawienie strefy czasowej
date_default_timezone_set('Europe/Warsaw');

require 'vendor/autoload.php';

use Vbert\VbCalendar\Constans\CalendarPL;
use Vbert\VbCalendar\Calendar\CalendarDay;

$lang = new CalendarPL();
$day = new CalendarDay(2024, 11, 9, $lang);


var_dump([
    'lang' => $lang,
    'day' => $day,
    'dayName' => $day->getDayName(),
    'isWeekend' => $day->isWeekend(),
    'isToday' => $day->isToday(),
]);

