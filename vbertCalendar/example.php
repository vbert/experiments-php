<?php
/*
 * Project: Vbert\VbertCalendar
 * File: /example.php
 * File Created: 2024-10-28, 10:25:02
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-28, 14:07:27
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
?>
<?php
header('Content-type: text/html; charset=utf-8');
setlocale(LC_TIME, 'pl_PL.UTF8');
// Ustawienie strefy czasowej
date_default_timezone_set('Europe/Warsaw');

require 'vendor/autoload.php';

use Vbert\VbertCalendar\Constans\CalendarLangPL;
use Vbert\VbertCalendar\Calendar\HorizontalMonthlyCalendar;

$calendar = new HorizontalMonthlyCalendar(new CalendarLangPL());
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Horizontal Montly Calendar</title>
        <link href="./style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav class="navtop">
            <div>
                <h1 class="title">Horizontal Montly Calendar</h1>
            </div>
        </nav>
        <div class="content home">
            <h2 class="subtitle"></h2>

            <?php $calendar->generate(); ?>
        </div>
    </body>
</html>
