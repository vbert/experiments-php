<?php
/*
 * Project: calendar-05
 * File: /example.php
 * File Created: 2024-06-15, 21:26:38
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-16, 20:59:43
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

require_once __DIR__ . '/Renderer.php';
require_once __DIR__ . '/Calendar.php';
require_once __DIR__ . '/Template.php';

$templateDir = __DIR__ . '/templates';
$template = new Template($templateDir);

// $calendar = new MonthlyCalendar();
// $renderer = new MonthlyTemplateRenderer($template);

// $calendar = new WeeklyCalendar();
// $renderer = new WeeklyTemplateRenderer($template);

$calendar = new YearlyCalendar();
$renderer = new YearlyTemplateRenderer($template);

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
                <h1>Event Calendar</h1>
            </div>
        </nav>
        <div class="content home">
            <?php
                echo $calendarView->render(2024, 6);
            ?>
        </div>
    </body>
</html>
