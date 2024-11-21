<?php
/*
 * Project: VbCalendar/EventObject
 * File: /GeneralObjectInterface.php
 * File Created: 2024-11-06, 23:02:13
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-21, 22:53:32
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\EventObject;

use Vbert\VbCalendar\Event\EventInterface;

interface GeneralObjectInterface {
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): ?string;
    public function getMetadata(): array;
    public function getEvents(): array;
    public function getEvent(int $id): ?EventInterface;
    public function addEvent(EventInterface $event): void;
    public function editEvent(EventInterface $event, $data=[]): void;
    public function removeEvent(EventInterface $event): void;
}
