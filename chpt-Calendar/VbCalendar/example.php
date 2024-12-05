<?php
/*
 * Project: VbCalendar
 * File: /example.php
 * File Created: 2024-11-07, 0:32:18
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-25, 21:54:07
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
use Vbert\VbCalendar\Calendar\MonthlyHorizontalCalendar;
use Vbert\VbCalendar\Calendar\MonthlyHorizontalCalendarRenderer;
use Vbert\VbCalendar\Event\SkiRental;
use Vbert\VbCalendar\EventObject\Color;
use Vbert\VbCalendar\EventObject\Ski;

// Set default values year and month.
$requestedYear = (int) filter_input(INPUT_GET, 'y', FILTER_SANITIZE_NUMBER_INT) ?: date('Y');
$requestedMonth = (int) filter_input(INPUT_GET, 'm', FILTER_SANITIZE_NUMBER_INT) ?: date('n');

$lang = new CalendarPL();
$calendar = new MonthlyHorizontalCalendar($requestedYear, $requestedMonth, $lang);

// Set event -> ski rental
$rentals[] = new SkiRental(
    1,
    1,
    67,
    new DateTime('2024-11-5'),
    new DateTime('2024-11-26'),
    [
        'description' => 'Skis for beginners'
    ]
);

$rentals[] = new SkiRental(
    2,
    2,
    247,
    new DateTime('2024-10-28'),
    new DateTime('2024-11-7'),
    [
        'description' => 'Skis for beginners'
    ]
);

$rentals[] = new SkiRental(
    3,
    2,
    35,
    new DateTime('2024-11-28'),
    new DateTime('2024-12-21'),
    [
        'description' => 'Skis for beginners'
    ]
);

$rentals[] = new SkiRental(
    4,
    3,
    67,
    new DateTime('2024-11-1'),
    new DateTime('2024-11-6'),
    [
        'description' => 'Skis for beginners'
    ]
);

$rentals[] = new SkiRental(
    5,
    4,
    67,
    new DateTime('2024-11-7'),
    new DateTime('2024-11-16'),
    [
        'description' => 'Skis for beginners'
    ]
);

$rentals[] = new SkiRental(
    6,
    5,
    67,
    new DateTime('2024-11-10'),
    new DateTime('2024-11-25'),
    [
        'description' => 'Skis for beginners'
    ]
);

$rentals[] = new SkiRental(
    7,
    5,
    67,
    new DateTime('2024-11-5'),
    new DateTime('2024-11-5'),
    [
        'description' => 'Skis for beginners'
    ]
);

$rentals[] = new SkiRental(
    8,
    6,
    67,
    new DateTime('2024-11-3'),
    new DateTime('2024-11-17'),
    [
        'description' => 'Skis for beginners'
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

$skis[] = new Ski(3, [
    'mark' => 'Nike',
    'model' => 'ski 1000',
    'length' => 160,
    'description' => 'Skis for professionals'
]);

$skis[] = new Ski(4, [
    'mark' => 'Converse',
    'model' => 'Mulda 8',
    'length' => 180,
    'description' => 'Skis for professionals'
]);

$skis[] = new Ski(5, [
    'mark' => 'Nike',
    'model' => 'ski 1400',
    'length' => 160,
    'description' => 'Skis for professionals'
]);

$skis[] = new Ski(6, [
    'mark' => 'Nike',
    'model' => 'ski 1400',
    'length' => 160,
    'description' => 'Skis for professionals'
]);

$skis[0]->addEvent($rentals[0]);
$skis[1]->addEvent($rentals[1]);
$skis[1]->addEvent($rentals[2]);
$skis[2]->addEvent($rentals[3]);
$skis[3]->addEvent($rentals[4]);
$skis[4]->addEvent($rentals[5]);
$skis[4]->addEvent($rentals[6]);
$skis[5]->addEvent($rentals[7]);

$color = new Color();

// var_dump([
//     'lang' => $lang,
//     'requestedYear' => $requestedYear,
//     'requestedMonth' => $requestedMonth,
//     // Test ValueObject: $day
//     'day' => $day,
//     'dayName' => $day->getDayName(),
//     'isWeekend' => $day->isWeekend(),
//     'isToday' => $day->isToday(),
//     // 'calendar' => $calendar,
//     'skis' => $skis,
//     'rental' => $rentals[0],
//     'rentalData' => [
//         'eventId' => $rental->getEventId(),
//         'objectId' => $rental->getObjectId(),
//         'clientId' => $rental->getClientId(),
//         'description' => $rental->getDescription(),
//         'startDate' => $rental->getStartDate()->format('d.m.Y'),
//         'endDate' => $rental->getEndDate()->format('d.m.Y'),
//         'duration' => $rental->getDuration(),
//         'occursOn' => $rental->occursOn($day),
//     ],
// ]);

$calendarRenderer = new MonthlyHorizontalCalendarRenderer($calendar, $skis, 'Narty do wypożyczenia');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Calendar</title>
    <!-- Bootstrap 5.3 CSS -->
    <link rel="stylesheet" href="./bootstrap.min.css">
    <!-- Zebra_DatePicker CSS -->
    <link rel="stylesheet" href="./zebra_datepicker.min.css">
    <!-- style.css -->
    <link rel="stylesheet" href="./style.css">
</head>
<body class="container-fluid">
<div class="mb-4 calendar-events">
    <?=$calendarRenderer->render();?>
</div>
<!-- JQuery -->
<script src="./jquery-3.6.0.min.js"></script>
<!-- Zebra_DatePicker JavaScript -->
<script src="./zebra_datepicker.min.js"></script>
</body>
</html>
