<?php
/*
 * Project: VbCalendar/Event
 * File: /SkiRental.php
 * File Created: 2024-11-07, 14:31:36
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 15:36:27
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Event;

use DateTime;

use Vbert\VbCalendar\Event\EventInterface;
use Vbert\VbCalendar\Calendar\CalendarDay;


class SkiRental implements EventInterface {
    private int $eventId;
    private array $metadata;
    private DateTime $startDate;
    private DateTime $endDate;
    private int $duration;


    public function __construct(int $eventId, DateTime $startDate, DateTime $endDate, array $metadata) {
        $this->eventId = $eventId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->metadata = $metadata;

        $this->calculateDuration();
    }

    public function getEventId(): int {
        return $this->eventId;
    }

    public function getObjectId(): int {

        if (array_key_exists('objectId', $this->metadata)) {
            return $this->metadata['objectId'];
        }
        return 0;
    }

    public function getClientId(): int {

        if (array_key_exists('clientId', $this->metadata)) {
            return $this->metadata['clientId'];
        }
        return 0;
    }

    public function getMetadata(): array {
        return $this->metadata;
    }

    public function setMetadata(array $metadata): void {
        $this->metadata = array_merge($this->metadata, $metadata);
    }

    public function getStartDate(): DateTime {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): void {
        $this->startDate = $startDate;
    }

    public function getEndDate(): DateTime {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): void {
        $this->endDate = $endDate;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function getDescription(): string {

        if (array_key_exists('description', $this->metadata)) {
            return $this->metadata['description'];
        }
        return '';
    }

    public function getColor(): string {

        if (array_key_exists('color', $this->metadata)) {
            return $this->metadata['color'];
        }
        return '';
    }

    public function occursOn(CalendarDay $day): bool {
        $date = new DateTime($day->getDate());
        return $date >= $this->startDate && $date <= $this->endDate;
    }

    private function calculateDuration() {
        $interval = $this->startDate->diff($this->endDate);
        $this->duration = $interval->days;
    }
}
