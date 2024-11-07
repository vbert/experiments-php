<?php
/*
 * Project: VbCalendar/Event
 * File: /EventInterface.php
 * File Created: 2024-11-06, 23:06:44
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 0:30:55
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Event;

use DateTime;

use Vbert\VbCalendar\Calendar\CalendarDay;

interface EventInterface {
    public function getId(): int;
    public function getMetadata(): array;
    public function getStartDate(): DateTime;
    public function getEndDate(): DateTime;
    public function setStartDate(DateTime $startDate);
    public function setEndDate(DateTime $endDate);
    public function occursOn(CalendarDay $day);
}
