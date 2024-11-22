<?php
/*
 * Project: VbCalendar
 * File: /example.php
 * File Created: 2024-11-07, 0:32:18
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-22, 10:09:59
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
use Vbert\VbCalendar\EventObject\Color;
use Vbert\VbCalendar\EventObject\Ski;

// Set default values year and month.
$requestedYear = (int) filter_input(INPUT_GET, 'y', FILTER_SANITIZE_NUMBER_INT) ?: date('Y');
$requestedMonth = (int) filter_input(INPUT_GET, 'm', FILTER_SANITIZE_NUMBER_INT) ?: date('n');

$lang = new CalendarPL();
$calendar = new MonthlyCalendar($requestedYear, $requestedMonth, $lang);

// Set event -> ski rental
$rental = new SkiRental(
    1, 
    new DateTime('2024-10-5'),
    new DateTime('2024-10-26'),
    [
        'description' => 'Skis for beginners',
        'objectId' => 123,
        'clientId' => 67,
        'color' => '#6666ff',
    ]
);

// Set one day value object
$day = new CalendarDay($requestedYear, $requestedMonth, 14, $lang);

// Set skis
$skis = [];

$skis[] = new Ski(1, [
    'mark' => 'Salomon',
    'model' => 'force X6',
    'length' => 180,
    'description' => 'Skis for professionals'
]);

$skis[] = new Ski(2, [
    'mark' => 'Salomon',
    'model' => 'force X7',
    'length' => 190,
    'description' => 'Skis for professionals'
]);

$ski_0 = $skis[0];

$color = new Color();

var_dump([
    'lang' => $lang,
    'requestedYear' => $requestedYear,
    'requestedMonth' => $requestedMonth,
    // Test ValueObject: $day
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
        'occursOn' => $rental->occursOn($day),
    ],
    'skis' => $skis,
    'ski_0' => [
        'id' => $ski_0->getId(),
        'name' => $ski_0->getName(),
        'description' => $ski_0->getDescription(),
        'mark' => $ski_0->getMark(),
        'model' => $ski_0->getModel(),
        'length' => $ski_0->getLength(),
        'events' => $ski_0->getEvents(),
    ]
]);

