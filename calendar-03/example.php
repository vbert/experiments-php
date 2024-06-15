<?php
/*
 * Project: calendar-03
 * File: /example.php
 * File Created: 2024-06-14, 11:40:15
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-06-14, 22:26:06
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

include 'Calendar.php';
$calendar = new CalendarOld('2024-05-01');
$calendar->add_event('Birthday', '2024-05-03', 1, 'green');
$calendar->add_event('Doctors', '2024-05-04', 1, 'red');
$calendar->add_event('Holiday', '2024-05-16', 7);
$calendar->add_event('Test second event', '2024-05-20', 2, 'red');


var_dump([
    date('D N', strtotime('2024-06-10')),
    date('D N', strtotime('2024-06-11')),
    date('D N', strtotime('2024-06-12')),
    date('D N', strtotime('2024-06-13')),
    date('D N', strtotime('2024-06-14')),
    date('D N', strtotime('2024-06-15')),
    date('D N', strtotime('2024-06-16')),
    date('D N', strtotime('2024-06-17'))
]);


$firstday = date('l (N) - d/m/Y', strtotime('this week'));
echo "First day of this week: ", $firstday;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Event Calendar</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="calendar.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav class="navtop">
            <div>
                <h1>Event Calendar</h1>
            </div>
        </nav>
        <div class="content home">
            <?php
                echo $calendar;
                //var_dump($calendar->getArrayMonth());
            ?>
        </div>
    </body>
</html>