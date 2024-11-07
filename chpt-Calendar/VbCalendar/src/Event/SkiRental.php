<?php
/*
 * Project: VbCalendar/Event
 * File: /SkiRental.php
 * File Created: 2024-11-07, 14:31:36
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-07, 23:31:45
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
    private DateTime $returnDate;
    private int $duration;


    public function __construct(int $eventId, DateTime $startDate, DateTime $endDate, array $metadata=[]) {
        $this->eventId = $eventId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->metadata = $metadata;

        $this->calculateDuration();
    }

    public function getEventId(): int {
        return $this->eventId;
    }

    public function getObjectId(): ?int {
        return $this->metadata['objectId'] ?? null;
    }

    public function getClientId(): ?int {
        return $this->metadata['clientId'] ?? null;
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

    public function getReturnDate(): DateTime {
        return $this->returnDate;
    }

    public function setReturnDate(DateTime $returnDate): void {
        $this->returnDate = $returnDate;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function getDescription(): ?string {
        return $this->metadata['description'] ?? null;
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
