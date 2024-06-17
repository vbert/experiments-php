<?php
/*
 * Project: date-operations
 * File: /example.php
 * File Created: 2024-06-17, 11:39:33
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-06-17, 20:57:26
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

// Ustawienie strefy czasowej
date_default_timezone_set('Europe/Warsaw');

// Sprawdzenie, czy przekazano numer tygodnia
if (isset($_POST['week_offset'])) {
    $weekOffset = (int)$_POST['week_offset'];
} else {
    $weekOffset = 0;
}

// Dzisiejsza data
$today = new DateTime();
$today->modify("$weekOffset week");

// Numer tygodnia w roku
$weekNumber = $today->format('W');

// Pierwszy dzień tygodnia (Poniedziałek)
$firstDayOfWeek = clone $today;
$firstDayOfWeek->modify('Monday this week');

// Ostatni dzień tygodnia (Niedziela)
$lastDayOfWeek = clone $today;
$lastDayOfWeek->modify('Sunday this week');

// Tablica z datami dni tygodnia
$daysOfWeek = array();
for ($i = 0; $i < 7; $i++) {
    $day = clone $firstDayOfWeek;
    $day->modify("+$i day");
    $daysOfWeek[] = $day->format('Y-m-d');
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Tygodnie</title>
</head>
<body>
    <div>
        <h1>Tygodnie</h1>
        <p>WeekOffset: <?= $weekOffset; ?></p>
        <p>Numer tygodnia: <?=$weekNumber; ?></p>
        <p>Pierwszy dzień: <?=$firstDayOfWeek->format('Y-m-d'); ?></p>
        <p>Ostatni dzień: <?=$lastDayOfWeek->format('Y-m-d'); ?></p>
        <p>Dni tygodnia: <?=implode(', ', $daysOfWeek); ?></p>
    </div>
    <form method="post">
        <button type="submit" name="week_offset" value="<?=$weekOffset - 1; ?>">
            Poprzedni tydzień</button>
        <button type="submit" name="week_offset" value="<?=$weekOffset + 1; ?>">
            Następny tydzień</button>
    </form>
</body>
</html>
