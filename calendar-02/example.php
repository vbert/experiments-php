<?php
/*
 * Project: experiments-php
 * File: /calendar-02.php
 * File Created: 2024-06-14, 9:07:42
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-06-14, 11:49:44
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

$monthCalendars = [];

$year = 2024;
$date = new DateTime(''.$year.'-01-01');
$weekday = (int) $date->format('N');
$weekn = (int) $date->format('W');
$day = 1;
$month = 1;
$dayLabels = array('Po', 'Wt', 'Śr', 'Cz', 'Pi', 'So', 'Ni');


var_dump([
    $year,
    $date,
    $weekday,
    $weekn,
]);


// This creates a "table head" for each month
$thead = '<tr>';//<th>M</th><th>W</th>';
foreach($dayLabels as $lbl) {
    $thead .= '<th>'.$lbl.'</th>';
}
$thead .= '</tr>';

$arrayCalendar = [];

// Loop each month until 12
for(;$month <= 12; $month++) {
    // This variable will hold the html table of the calendar
    $calendar = '<table id="calendar" border="1" style="width: auto; max-width: 100%;">';

    $arrayCalendar[$month] = [];
    $rowMonth = 0;

    $calendar .= $thead;
    $monthday = 1;
    $monthmax = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $position = 0;

    while($monthday <= $monthmax) {
        // Create month and week columns
        if ($position === 0) {
            $weekn = (int) $date->format('W');
            $calendar .= '<tr>'; //<th>'.$month.'</th><th>'.$weekn.'</th>';

            $arrayCalendar[$month][$rowMonth] = [];

            $position++;
        } // Create "non-days"
        else if ($position < $weekday) {
            $calendar .= '<td class="nonday"></td>';

            $arrayCalendar[$month][$rowMonth][$position] = 0;

            $position++;
        } // Create days
        else if($position === $weekday) {
            $calendar .= '<td class="day">'.$monthday.'</td>';

            $arrayCalendar[$month][$rowMonth][$position] = $monthday;

            $position++;
            $weekday++;
            $monthday++;
            $date->modify('+1 day');

            if ($position === 8) {
                $position = 0;
                $weekday = 1;
                $rowMonth++;
            }
        }
    }

    // Finish "non-days"
    while($position !== 0) {
        $calendar .= '<td class="nonday"></td>';

        $arrayCalendar[$month][$rowMonth][$position] = 0;

        $position++;
        if($position === 8) {
            $position = 0;
        }
    }

    $calendar .= '</tr>';
    // if ($month != 12) {
    //     $calendar .= '<td colspan="9" class="monthlinebreak"></td>';
    // }

    $calendar .= '</table>';

    $monthCalendars[$month] = [
        'calendar' => $calendar,
        // 'arrayCalendar' => $arrayCalendar
    ];
}


print_r($monthCalendars);

var_dump($arrayCalendar);

// return $calendar;