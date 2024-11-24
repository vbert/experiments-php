<?php
/*
 * Project: VbCalendar/EventObject
 * File: /Ski.php
 * File Created: 2024-11-21, 21:29:51
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-24, 17:59:20
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
    private string $color;
    private array $metadata;
    private array $events = [];


    public function __construct(int $id, array $metadata, $color=null) {
        $this->id = $id;
        $this->metadata = $metadata;
        $this->name = $this->setName();

        $this->color = $color ?? Color::get();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getColor(): string {
        return $this->color;
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
