<?php
/*
 * Project: VbCalendar
 * File: /example.php
 * File Created: 2024-11-07, 0:32:18
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 15:37:28
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
use Vbert\VbCalendar\Calendar\MonthlyCalendar;
use Vbert\VbCalendar\Event\SkiRental;

// Set default values year and month.
$requestedYear = (int) filter_input(INPUT_GET, 'y', FILTER_SANITIZE_NUMBER_INT) ?: date('Y');
$requestedMonth = (int) filter_input(INPUT_GET, 'm', FILTER_SANITIZE_NUMBER_INT) ?: date('n');
// Set lang.
$lang = new CalendarPL();
// Set one day value object
$day = new CalendarDay($requestedYear, $requestedMonth, 9, $lang);

// Set monthly calendar
$calendar = new MonthlyCalendar($requestedYear, $requestedMonth, $lang);

// Set ski rental
$rental = new SkiRental(
    1, 
    new DateTime("2024-10-25"),
    new DateTime("2024-10-26"),
    [
        'description' => 'Skis for beginners',
        'objectId' => 123,
        'clientId' => 67,
        'color' => '#6666ff',
    ]
);

var_dump([
    'lang' => $lang,
    'requestedYear' => $requestedYear,
    'requestedMonth' => $requestedMonth,
    'day' => $day,
    'dayName' => $day->getDayName(),
    'isWeekend' => $day->isWeekend(),
    'isToday' => $day->isToday(),
    // 'calendar' => $calendar,
    'rental' => [
        'objectId' => $rental->getObjectId(),
        'clientId' => $rental->getClientId(),
        'description' => $rental->getDescription(),
        'startDate' => $rental->getStartDate()->format('d.m.Y'),
        'endDate' => $rental->getEndDate()->format('d.m.Y'),
        'duration' => $rental->getDuration(),
        'color' => $rental->getColor(),
    ],
]);

