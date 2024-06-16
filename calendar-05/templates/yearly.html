<!--
Project: templates
File: /yearly.html
File Created: 2024-06-15, 21:32:24
Author: Wojciech Sobczak (wsobczak@gmail.com)
-----
Last Modified: 2024-06-15, 21:32:43
Modified By: Wojciech Sobczak (wsobczak@gmail.com)
-----
Copyright © 2021 - 2024 by vbert
-->
<div class="calendar">
    <?php foreach ($data as $month => $days): ?>
        <div class="calendar-month">
            <div class="calendar-header"><?= DateTime::createFromFormat('!m', $month)->format('F') ?></div>
            <div class="calendar-row calendar-header">
                <?php foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dayName): ?>
                    <div class="calendar-cell"><?= $dayName ?></div>
                <?php endforeach; ?>
            </div>
            <?php
            $week = [];
            foreach ($days as $date):
                if ($date->format('N') == 1 && count($week) > 0):
                    echo '<div class="calendar-row">' . implode('', $week) . '</div>';
                    $week = [];
                endif;
                $week[] = '<div class="calendar-cell"><a href="?year=' . $date->format('Y') . '&month=' . $date->format('m') . '&day=' . $date->format('d') . '" class="day-number">' . $date->format('j') . '</a></div>';
            endforeach;
            if (count($week) > 0):
                echo '<div class="calendar-row">' . implode('', $week) . '</div>';
            endif;
            ?>
        </div>
    <?php endforeach; ?>
</div>
