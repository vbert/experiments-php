<!--
Project: templates
File: /monthly.html
File Created: 2024-06-15, 21:30:40
Author: Wojciech Sobczak (wsobczak@gmail.com)
-----
Last Modified: 2024-06-15, 21:30:58
Modified By: Wojciech Sobczak (wsobczak@gmail.com)
-----
Copyright © 2021 - 2024 by vbert
-->
<div class="calendar">
    <div class="calendar-row calendar-header">
        <?php foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dayName): ?>
            <div class="calendar-cell"><?= $dayName ?></div>
        <?php endforeach; ?>
    </div>
    <?php foreach ($data as $week): ?>
        <div class="calendar-row">
            <?php foreach ($week as $date): ?>
                <div class="calendar-cell <?= $date->format('m') != $month ? 'other-month' : '' ?>">
                    <a class="day-number" href="?year=<?= $date->format('Y') ?>&month=<?= $date->format('m') ?>&day=<?= $date->format('d') ?>">
                        <?= $date->format('j') ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
