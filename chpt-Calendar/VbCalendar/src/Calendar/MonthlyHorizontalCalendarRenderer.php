<?php
/*
 * Project: Calendar
 * File: /MonthlyHorizontalCalendarRenderer.php
 * File Created: 2024-11-24, 11:39:29
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-24, 22:29:07
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Calendar;

use DateTime;

use Vbert\VbCalendar\Event\EventInterface;
use Vbert\VbCalendar\Calendar\CalendarInterface;
use Vbert\VbCalendar\EventObject\GeneralObjectInterface;



class MonthlyHorizontalCalendarRenderer implements CalendarRendererInterface {
    private string $containerHtmlTpl = '';
    private string $headerHtmlTpl = '';
    private string $headerContentHtmlTpl = '';
    private string $bodyHtmlTpl = '';
    private string $rowObjectHtmlTpl = '';
    private string $footerHtmlTpl = '';
    private string $footerContentHtmlTpl = '';
    private CalendarInterface $calendar;
    private array $objects;
    private string $objectsName;


    public function __construct(CalendarInterface $calendar, array $objects, string $objectsName=null) {
        $this->calendar = $calendar;
        $this->objects = $objects;
        $this->objectsName = $objectsName ?: 'Objekty';
    }

    public function render(): string {
        $header = $this->renderHeader();
        $body = $this->renderBody();
        $footer = '';

        return sprintf($this->getContainerHtmlTmplate(), $header, $body, $footer);
    }

    private function renderHeader(): string {
        $dayNumbers = $this->renderDayNumbers();
        $dayNames = $this->renderDayNames();
        $content = sprintf($this->getHeaderContentHtmlTmplate(), $dayNumbers, $dayNames);

        return sprintf($this->getHeaderHtmlTmplate(), $content);
    }

    private function renderDayNumbers(): string {
        $html = '';
        $html .= $this->getCellHtml('th', ['class' => 'object-list', 'rowspan' => '2'], $this->objectsName);

        foreach ($this->calendar->getDays() as $day) {
            $dayNumber = (int)date('j', strtotime($day->getDate()));
            $fullDate = $day->getDate();
            $attributes = ['data-day' => $fullDate];
            $dayClass = $this->calculateCssClass($day);

            if ($dayClass) {
                $attributes['class'] = $dayClass;
            }
            $html .= $this->getCellHtml('th', $attributes, $dayNumber);
        }

        return $html;
    }

    private function renderDayNames(): string {
        $html = '';

        foreach ($this->calendar->getDays() as $day) {
            $dayName = $day->getDayName();
            $attributes = [];
            $dayClass = $this->calculateCssClass($day);

            if ($dayClass) {
                $attributes['class'] = $dayClass;
            }
            $html .= $this->getCellHtml('td', $attributes, $dayName);
        }

        return $html;
    }

    private function renderBody (): string {
        $objectsRows = '';

        foreach ($this->objects as $object) {
            $objectsRows .= $this->renderObjectRow($object);
        }

        return sprintf($this->getBodyHtmlTmplate(), $objectsRows);
    }

    private function renderObjectRow(GeneralObjectInterface $object): string {
        $html = $this->getCellHtml('td', ['class' => 'object'], $object->getName());

        $days = $this->calendar->getDays();

        for ($i = 0; $i < count($days); $i++) {
            $day = $days[$i];
            $event = $this->getEventForDay($object, $day);

            if ($event) {
                $eventName = $this->getFormattedEventName($event, $day);
                $urlEditEvent = '#';

                // Obliczenie indeksu końcowego wydarzenia w bieżącym miesiącu
                $startDayIndex = $i;
                $endDayIndex = $startDayIndex;

                while ($endDayIndex + 1 < count($days) && $this->getEventForDay($object, $days[$endDayIndex + 1]) === $event) {
                    $endDayIndex++;
                }

                // Sprawdzenie, czy wydarzenie trwa z poprzedniego lub do następnego miesiąca
                $startEventMonth = $event->getStartDate()->format('Y-n');
                $endEventMonth = $event->getEndDate()->format('Y-n');
                $currentMonth = "{$this->calendar->getYear()}-{$this->calendar->getMonth()}";
                $isEventContinuedFromPreviousMonth = $startEventMonth < $currentMonth;
                $isEventContinuedToNextMonth = $endEventMonth > $currentMonth;

                // Renderowanie wydarzenia dla każdego dnia w bieżącym miesiącu
                for ($j = $startDayIndex; $j <= $endDayIndex; $j++) {
                    $day = $days[$j];
                    $dayClass = '';
                    $cssClasses = ['calendar-event'];

                    if ($j === $startDayIndex && $j === $endDayIndex && !$isEventContinuedFromPreviousMonth && !$isEventContinuedToNextMonth) {
                        // Wydarzenie trwa tylko jeden dzień
                        $cssClasses[] = 'rounded';
                    } elseif ($j === $startDayIndex && !$isEventContinuedFromPreviousMonth) {
                        // Pierwszy dzień wydarzenia
                        $cssClasses[] = 'rounded-start';
                    } elseif ($j === $endDayIndex && !$isEventContinuedToNextMonth) {
                        // Ostatni dzień wydarzenia
                        $cssClasses[] = 'rounded-end';
                    }

                    $dayClass = $this->calculateCssClass($day, $cssClasses);

                    $attributes = [
                        'href' => $urlEditEvent,
                        'class' => 'calendar-event-bar',
                        'data-event-name' => $eventName,
                        'style' => "background-color: {$object->getColor()};",
                    ];
                    $content = $this->getCellHtml('a', $attributes, '&nbsp;');

                    // Renderowanie pojedynczej komórki wydarzenia
                    $attributes = $dayClass ? ['class' => $dayClass] : [];
                    $html .= $this->getCellHtml('td', $attributes, $content);
                }

                // Przeskocz do ostatniego dnia wydarzenia
                $i = $endDayIndex;
            } else {
                $dayClass = $this->calculateCssClass($day);
                $attributes = $dayClass ? ['class' => $dayClass] : [];
                $html .= $this->getCellHtml('td', $attributes, '&nbsp;');
            }
        }

        return sprintf($this->getRowObjectHtmlTmplate(), $html);
    }

    private function getEventForDay(GeneralObjectInterface $object, CalendarDay $day): ?EventInterface {
        foreach ($object->getEvents() as $event) {

            if ($event->occursOn($day)) {
                return $event;
            }
        }
        return null;
    }

    private function getFormattedEventName(EventInterface $event, CalendarDay $day): string {
        $calendarDays = $this->calendar->getDays();
        $isBeforeStartOfMonth = $event->getStartDate() < new DateTime($calendarDays[0]->getDate());
        $isAfterEndOfMonth = $event->getEndDate() > new DateTime(end($calendarDays)->getDate());
        $eventName = '';

        if ($isBeforeStartOfMonth) {
            $eventName = "... {$eventName}";
        }

        if ($isAfterEndOfMonth) {
            $eventName .= " ...";
        }

        return $eventName;
    }

    private function calculateCssClass($day, $cssClass = []): string {
        $dayClass = '';

        if ($day->isWeekend()) {
            $cssClass[] = 'weekend';
        }

        if ($day->isToday()) {
            $cssClass[] = 'today';
        }

        if (count($cssClass) > 0) {
            $dayClass = implode(' ', $cssClass);
        }

        return $dayClass;
    }

    public function getContainerHtmlTmplate(): string {
        $defaultContainerHtml = <<<HTML
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover table-bordered table-events">
                %s
                %s
                %s
            </table>
        </div>
        HTML;

        return $this->containerHtmlTpl ?: $defaultContainerHtml;
    }

    public function getHeaderHtmlTmplate(): string {
        $defaultHeaderHtml = <<<HTML
        <thead>
            %s
        </thead>
        HTML;

        return $this->headerHtmlTpl ?: $defaultHeaderHtml;
    }

    public function getHeaderContentHtmlTmplate (): string {
        $defaultHeaderContentHtml = <<<HTML
        <tr>
            %s
        </tr>
        <tr class="weekdays">
            %s
        </tr>
        HTML;

        return $this->headerContentHtmlTpl ?: $defaultHeaderContentHtml;
    }

    public function getBodyHtmlTmplate (): string {
        $defaultBodyHtml = <<<HTML
        <tbody>
            %s
        </tbody>
        HTML;

        return $this->bodyHtmlTpl ?: $defaultBodyHtml;
    }

    public function getRowObjectHtmlTmplate (): string {
        $defaultRowObjectHtml = <<<HTML
        <tr>
            %s
        </tr>
        HTML;

        return $this->rowObjectHtmlTpl ?: $defaultRowObjectHtml;
    }

    public function getFooterHtmlTmplate(): string {
        $defaultFooterHtml = <<<HTML
        <tfoot>
            %s
        </tfoot>
        HTML;

        return $this->footerHtmlTpl ?: $defaultFooterHtml;
    }

    public function getFooterContentHtmlTmplate (): string {
        $defaultFooterContentHtml = <<<HTML
        <tr>
            %s
        </tr>
        HTML;

        return $this->footerContentHtmlTpl ?: $defaultFooterContentHtml;
    }

    public function getCellHtml (string $tag='td', array $attributes=[], string $content=''): string {
        $format = '<%s%s>%s</%s>';

        $attr = '';
        foreach ($attributes as $key => $value) {
            $attr .= sprintf(' %s="%s"', $key, $value);
        }

        return sprintf($format, $tag, $attr, $content, $tag);
    }
}
