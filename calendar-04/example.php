<?php
/*
 * Project: calendar-04
 * File: /example.php
 * File Created: 2024-06-14, 20:02:43
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-06-14, 20:43:06
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

require __DIR__ . '/Calendar.php';

// Example Usage
$events = [
    '2024-06-14' => [new EventType('Event 1', '#ff9999'), new EventType('Event 2', '#99ff99')],
    '2024-06-15' => [new EventType('Event 3', '#9999ff')],
];

$calendar = new Calendar();
$renderer = new CalendarRenderer($calendar, $events);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendarz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?=$renderer->render();?>
</body>
</html>
