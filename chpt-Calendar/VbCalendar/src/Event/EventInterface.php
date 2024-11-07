<?php
/*
 * Project: VbCalendar/Event
 * File: /EventInterface.php
 * File Created: 2024-11-06, 23:06:44
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 22:00:49
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Event;

use DateTime;

use Vbert\VbCalendar\Calendar\CalendarDay;

interface EventInterface {
    public function getEventId(): int;
    public function getDescription(): ?string;
    public function getMetadata(): array;
    public function setMetadata(array $metadata): void;
    public function getStartDate(): DateTime;
    public function getEndDate(): DateTime;
    public function setStartDate(DateTime $startDate): void;
    public function setEndDate(DateTime $endDate): void;
    public function occursOn(CalendarDay $day): bool;
}
