<?php
/*
 * Project: VbCalendar/EventObject
 * File: /Ski.php
 * File Created: 2024-11-21, 21:29:51
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-21, 23:09:39
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\EventObject;

use DateTime;

use Vbert\VbCalendar\Event\EventInterface;
use Vbert\VbCalendar\EventObject\GeneralObjectInterface;


class Ski implements GeneralObjectInterface {
    private int $id;
    private string $name;
    private array $metadata;
    private array $events = [];

    // TODO: $color wrzucić do kalendarza podczas renderowania wiersza dla obiektu
    // TODO: $arrayColors też gdzieś do kalendarza, opracować metodę, która zwróci kolor na podstawie id wiersza generowanej tabeli
    private array $arrayColors = [
        '#0d6efd',
        '#6610f2',
        '#6f42c1',
        '#d63384',
        '#dc3545',
        '#fd7e14',
        '#ffc107',
        '#198754',
        '#20c997',
        '#0dcaf0',
    ];

    public function __construct(int $id, array $metadata) {
        $this->id = $id;
        $this->metadata = $metadata;
        $this->name = $this->setName();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName() {
        $name = [];

        if ($this->getMark()) {
            $name[] = $this->getMark();
        }

        if ($this->getModel()) {
            $name[] = $this->getModel();
        }

        if ($this->getLength()) {
            $name[] = (int) $this->getLength();
        }

        $name[] = "(id: {$this->getId()})";
        return implode(' ', $name);
    }

    public function getDescription(): ?string {
        return $this->metadata['description'] ?? null;
    }

    public function getMetadata(): array {
        return $this->metadata;
    }

    public function getMark(): ?string {
        return $this->metadata['mark'] ?? null;
    }

    public function getModel(): ?string {
        return $this->metadata['model'] ?? null;
    }

    public function getLength(): ?string {
        return $this->metadata['length'] ?? null;
    }

    public function getEvents(): array {
        return $this->events;
    }

    public function getEvent(int $eventId): ?EventInterface {

        if (count($this->events) > 0) {

            foreach ($this->events as $event) {

                if ($event->getEventId() === $eventId) {
                    return $event;
                }
            }
        }

        return null;
    }

    public function addEvent(EventInterface $event): void {
        $this->events[] = $event;
    }

    public function editEvent(EventInterface $event, $data=[]): void {

        if (array_key_exists('startDate', $data)) {
            $event->setStartDate($data['startDate']);
        }

        if (array_key_exists('endDate', $data)) {
            $event->setEndDate($data['endDate']);
        }

        if (array_key_exists('returnDate', $data)) {
            $event->setReturnDate($data['returnDate']);
        }
    }

    public function removeEvent(EventInterface $event): void {

        foreach ($this->events as $key => $value) {

            if ($value->getEventId() === $event->getEventId()) {
                unset($this->events[$key]);
            }
        }
    }
}
