<?php
/*
 * Project: calendar-05
 * File: /example.php
 * File Created: 2024-06-15, 21:26:38
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-28, 9:36:36
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

require_once __DIR__ . '/Renderer.php';
require_once __DIR__ . '/Calendar.php';
require_once __DIR__ . '/Template.php';

use vbert\experiments\calendar05\CalendarConstans;
use \vbert\experiments\calendar05\MonthlyCalendar;
use \vbert\experiments\calendar05\MonthlyTemplateRenderer;
use \vbert\experiments\calendar05\CalendarView;
use \vbert\experiments\calendar05\Template;

$templateDir = __DIR__ . '/templates';
$template = new Template($templateDir);

$calendar = new MonthlyCalendar();
$renderer = new MonthlyTemplateRenderer($template);

var_dump([
    'calendar' => $calendar,
]);

// $calendar = new WeeklyCalendar();
// $renderer = new WeeklyTemplateRenderer($template);

// $calendar = new YearlyCalendar();
// $renderer = new YearlyTemplateRenderer($template);

$year = date('Y'); // 2024;
$month = date('m'); // 6;
$day = date('d'); // 15;

$calendarView = new CalendarView($calendar, $renderer);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Event Calendar</title>
        <link href="./style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav class="navtop">
            <div>
                <h1 class="title">Event Calendar</h1>
            </div>
        </nav>
        <div class="content home">
            <h2 class="subtitle"><?= CalendarConstans::monthName($month, CalendarConstans::NAME_FULL) ?> <?= $year ?></h2>
            <?= $calendarView->render($year, $month); ?>
        </div>
    </body>
</html>
