<?php
/*
 * Project: VbCalendar/Event
 * File: /GeneralObjectInterface.php
 * File Created: 2024-11-06, 23:02:13
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-06, 23:47:44
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Event;

use DateTime;

use Vbert\VbCalendar\Event\EventInterface;

interface GeneralObjectInterface {
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): string;
    public function getMetadata(): array;
    // public function getColor(): string;
    // public function getUrlAddEvent(): string;
    // public function getUrlEditEvent(): string;
    // public function getUrlRemoveEvent(): string;
    public function getEvents(): array;
    public function getEvent(int $id): EventInterface;
    public function addEvent(EventInterface $event): void;
    public function editEvent(EventInterface $event, DateTime $startDate, DateTime $endDate): void;
    public function removeEvent(EventInterface $event): void;
}
