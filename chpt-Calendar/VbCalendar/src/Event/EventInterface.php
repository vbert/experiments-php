<?php
/*
 * Project: VbCalendar/Event
 * File: /EventInterface.php
 * File Created: 2024-11-06, 23:06:44
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-24, 18:22:10
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Event;

use DateTime;

use Vbert\VbCalendar\Calendar\CalendarDay;

interface EventInterface {
    public function getEventId(): int;
    public function getObjectId(): int;
    public function getClientId(): int;
    public function getDescription(): ?string;
    public function getMetadata(): array;
    public function setMetadata(array $metadata): void;
    public function getStartDate(): DateTime;
    public function setStartDate(DateTime $startDate): void;
    public function getEndDate(): DateTime;
    public function setEndDate(DateTime $endDate): void;
    public function getReturnDate(): ?DateTime;
    public function setReturnDate (DateTime $returnDate): void;
    public function occursOn(CalendarDay $day): bool;
}
