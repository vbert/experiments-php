<?php
/*
 * Project: chptCalendar-02
 * File: /calendar.php
 * File Created: 2024-10-29, 9:36:40
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-24, 18:24:21
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

// GeneralObject interface with extended methods
interface GeneralObject {
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): string;
    public function getColor(): string;
    public function getUrlEditEvent(): string;
    public function getUrlAddEvent(): string;
    public function getEvents(): array;
    public function addEvent(Event $event): void;
    public function editEvent(Event $event, DateTime $newStartDate, DateTime $newEndDate): void;
}

class Skis implements GeneralObject {
    private int $id;
    private string $name;
    private string $description;
    private string $color;
    private array $events = [];
    private string $generalUrlAddEvent;
    private string $generalUrlEditEvent;

    public function __construct(int $id, string $name, string $description, string $color) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->color = $color;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getColor(): string {
        return $this->color;
    }

    public function getUrlAddEvent(): string {
        return "/add_event.php?id=" . $this->id;
    }

    public function setGeneralUrlEditEvent(string $url=''): void {
        $this->generalUrlEditEvent = $url;
    }

    public function getUrlEditEvent(): string {
        return "/edit_event.php?id=" . $this->id;
    }

    public function getEvents(): array {
        return $this->events;
    }

    public function addEvent(Event $event): void {
        $this->events[] = $event;
    }

    public function editEvent(Event $event, DateTime $newStartDate, DateTime $newEndDate): void {
        $event->setStartDate($newStartDate);
        $event->setEndDate($newEndDate);
    }
}

class Event {
    private string $name;
    private DateTime $startDate;
    private DateTime $endDate;

    public function __construct(string $name, DateTime $startDate, DateTime $endDate) {
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getStartDate(): DateTime {
        return $this->startDate;
    }

    public function getEndDate(): DateTime {
        return $this->endDate;
    }

    public function setStartDate(DateTime $startDate): void {
        $this->startDate = $startDate;
    }

    public function setEndDate(DateTime $endDate): void {
        $this->endDate = $endDate;
    }

    public function occursOn(CalendarDay $day): bool {
        $date = new DateTime($day->getDate());
        return $date >= $this->startDate && $date <= $this->endDate;
    }
}

class Calendar {
    private int $year;
    private int $month;
    private array $days = [];

    public function __construct(int $year, int $month) {
        $this->year = $year;
        $this->month = $month;
        $this->initializeDays();
    }

    private function initializeDays(): void {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $this->days[] = new CalendarDay($this->year, $this->month, $day);
        }
    }

    public function getDays(): array {
        return $this->days;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function getMonth(): int {
        return $this->month;
    }

    public function setMonth(int $month): void {
        $this->month = $month;
        $this->initializeDays();
    }

    public function setYear(int $year): void {
        $this->year = $year;
        $this->initializeDays();
    }
}

// Klasa CalendarDay reprezentująca pojedynczy dzień w kalendarzu
class CalendarDay {
    private int $year;
    private int $month;
    private int $day;
    private string $dateString;
    private string $dayName;
    private int $dayWeekNumber;
    private int $dateTimestamp;

    public function __construct(int $year, int $month, int $day) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;

        $this->dateString = "$year-$month-$day";
        $this->dateTimestamp = strtotime($this->dateString);
        $this->dayWeekNumber = (int) date('N', $this->dateTimestamp);
        $this->dayName = date('D', $this->dateTimestamp);
    }

    public function getDate(): string {
        return $this->dateString;
    }

    public function getDayName(): string {
        return $this->dayName;
    }

    public function isWeekend(): bool {
        return in_array($this->dayWeekNumber, [6, 7]);
    }

    public function isToday(): bool {
        $today = new DateTime();
        return $today->format('Y-m-d') === $this->dateString;
    }
}

class CalendarRenderer {
    private Calendar $calendar;
    private array $objects;
    private string $objectsName;

    public function __construct(Calendar $calendar, array $objects, string $objectsName=null) {
        $this->calendar = $calendar;
        $this->objects = $objects;
        $this->objectsName = $objectsName ?: 'Objekty';
    }

    public function render(): string {
        $html = '<div class="table-responsive">';
        $html .= '<table class="table table-sm table-striped table-hover table-bordered table-events">';
        $html .= '<thead>';
        $html .= $this->renderDayNumbers();
        $html .= $this->renderDayNames();
        $html .= '</thead>';
        $html .= '<tbody class="table-group-divider">';

        foreach ($this->objects as $object) {
            $html .= $this->renderObjectRow($object);
        }

        $html .= '</tbody>';
        $html .= "</table>";
        $html .= '</div>';
        return $html;
    }

    private function renderDayNumbers(): string {
        $html = '<tr><th class="object-list" rowspan="2">Narty</th>';

        foreach ($this->calendar->getDays() as $day) {
            $dayNumber = (int)date('j', strtotime($day->getDate())); 
            $fullDate = $day->getDate();
            $dayClass = $this->calculateCssClass($day);
            $html .= "<th{$dayClass} data-day='{$fullDate}'>{$dayNumber}</th>";
        }

        $html .= "</tr>";
        return $html;
    }

    private function renderDayNames(): string {
        $html = '<tr class="weekdays">';

        foreach ($this->calendar->getDays() as $day) {
            $dayName = $day->getDayName();
            $dayClass = $this->calculateCssClass($day);
            $html .= "<td{$dayClass}>{$dayName}</td>";
        }

        $html .= "</tr>";
        return $html;
    }

    private function renderObjectRow(GeneralObject $object): string {
        $html = "<tr><td><a href='{$object->getUrlAddEvent()}'>{$object->getName()}</a></td>";
        $days = $this->calendar->getDays();

        for ($i = 0; $i < count($days); $i++) {
            $day = $days[$i];
            $event = $this->getEventForDay($object, $day);

            if ($event) {
                $eventName = $this->getFormattedEventName($event, $day);
                $urlEditEvent = $object->getUrlEditEvent();
                $eventColor = $object->getColor();

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
                        // Wydarzenie jednodniowe
                        $cssClasses[] = 'rounded';
                    } elseif ($j === $startDayIndex && !$isEventContinuedFromPreviousMonth) {
                        // Pierwszy dzień wydarzenia
                        // $cssClasses[] = $isEventContinuedFromPreviousMonth ? '' : 'rounded-left';
                        $cssClasses[] = 'rounded-left';
                    } elseif ($j === $endDayIndex && !$isEventContinuedToNextMonth) {
                        // Ostatni dzień wydarzenia
                        // $cssClasses[] = $isEventContinuedToNextMonth ? '' : 'rounded-right';
                        $cssClasses[] = 'rounded-right';
                    }

                    $dayClass = $this->calculateCssClass($day, $cssClasses);

                    // Renderowanie pojedynczej komórki wydarzenia
                    $html .= "<td{$dayClass}><a href='{$urlEditEvent}' class='calendar-event-bar' data-event-name='{$eventName}' style='background-color: {$eventColor};'>&nbsp;</a></td>";
                }

                // Przeskocz do ostatniego dnia wydarzenia
                $i = $endDayIndex;
            } else {
                $dayClass = $this->calculateCssClass($day);
                $html .= "<td{$dayClass}></td>";
            }
        }

        $html .= "</tr>";
        return $html;
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
            $dayClass = " class='". implode(' ', $cssClass) ."'";
        }

        return $dayClass;
    }

    private function getEventForDay(GeneralObject $object, CalendarDay $day): ?Event {

        foreach ($object->getEvents() as $event) {
            if ($event->occursOn($day)) {
                return $event;
            }
        }
        return null;
    }

    private function getFormattedEventName(Event $event, CalendarDay $day): string {
        $calendarDays = $this->calendar->getDays();
        $isBeforeStartOfMonth = $event->getStartDate() < new DateTime($calendarDays[0]->getDate());
        $isAfterEndOfMonth = $event->getEndDate() > new DateTime(end($calendarDays)->getDate());

        $eventName = $event->getName();

        if ($isBeforeStartOfMonth) {
            $eventName = "... {$eventName}";
        }
        if ($isAfterEndOfMonth) {
            $eventName .= " ...";
        }

        return $eventName;
    }
}

// Set default values
$requestedYear = filter_input(INPUT_GET, 'y', FILTER_SANITIZE_NUMBER_INT);
$requestedMonth = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_NUMBER_INT);

$requestedYear = (int) $requestedYear ?: date('Y');
$requestedMonth = (int) $requestedMonth ?: date('m');

// var_dump([
//     'requestedYear' => $requestedYear,
//     'requestedMonth' => $requestedMonth
// ]);

// Set up calendar and objects
$calendar = new Calendar($requestedYear, $requestedMonth);
$skis1 = new Skis(1, "Skis Red<br><small>To są czerwone narty dla Pana Starosty</small>", "Red colored skis for professionals.", "#ff6666");
$skis2 = new Skis(2, "Skis Blue", "Blue colored skis for beginners.", "#6666ff");
$skis3 = new Skis(3, "Skis Green", "Green colored skis for middle.", "#66ff66");

$event1 = new Event("Rental 1", new DateTime("2024-10-05"), new DateTime("2024-10-27"));
$event2 = new Event("Rental 2", new DateTime("2024-10-09"), new DateTime("2024-10-09"));
$event3 = new Event("Rental 3", new DateTime("2024-10-27"), new DateTime("2024-11-10"));
$event4 = new Event("Rental 4", new DateTime("2024-11-12"), new DateTime("2024-12-01"));
$event5 = new Event("Rental 5", new DateTime("2024-10-31"), new DateTime("2024-11-01"));

$skis2->addEvent($event5);
$skis1->addEvent($event1);
$skis1->addEvent($event3);
$skis1->addEvent($event4);
$skis3->addEvent($event2);

$renderedCalendar = new CalendarRenderer($calendar, [$skis1, $skis2, $skis3]);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Calendar</title>
    <!-- Bootstrap 5.3 CSS -->
    <link rel="stylesheet" href="./bootstrap.min.css">
    <!-- Zebra_DatePicker CSS -->
    <link rel="stylesheet" href="./zebra_datepicker.min.css">
    <!-- style.css -->
    <link rel="stylesheet" href="./style.css">
</head>
<body class="container-fluid">

<div class="mb-4 calendar-events">
    <div class="d-flex align-items-center justify-content-between mb-1">
        <div id="calendarNav" class="calendar-nav d-flex align-items-center justify-content-between mb-1">
            <div class="select-month">
                <!-- Previous month -->
                <a href="?y=2024&m=10" id="prevMonth" class="btn btn-secondary btn-sm me-2" title="Poprzedni"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16"><path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/></svg></a>
                <!-- Quick month selection buttons -->
                <a href="?y=2024&m=1" data-month="1" class="btn btn-outline-secondary btn-sm btn-month">Sty</a>
                <a href="?y=2024&m=2" data-month="2" class="btn btn-outline-secondary btn-sm btn-month">Lut</a>
                <a href="?y=2024&m=3" data-month="3" class="btn btn-outline-secondary btn-sm btn-month">Mar</a>
                <a href="?y=2024&m=4" data-month="4" class="btn btn-outline-secondary btn-sm btn-month">Kwi</a>
                <a href="?y=2024&m=5" data-month="5" class="btn btn-outline-secondary btn-sm btn-month">Maj</a>
                <a href="?y=2024&m=6" data-month="6" class="btn btn-outline-secondary btn-sm btn-month">Cze</a>
                <a href="?y=2024&m=7" data-month="7" class="btn btn-outline-secondary btn-sm btn-month">Lip</a>
                <a href="?y=2024&m=8" data-month="8" class="btn btn-outline-secondary btn-sm btn-month">Sie</a>
                <a href="?y=2024&m=9" data-month="9" class="btn btn-outline-secondary btn-sm btn-month">Wrz</a>
                <a href="?y=2024&m=10" data-month="10" class="btn btn-outline-secondary btn-sm btn-month">Paź</a>
                <a href="?y=2024&m=11" data-month="11" class="btn btn-outline-secondary btn-sm btn-month">Lis</a>
                <a href="?y=2024&m=12" data-month="12" class="btn btn-outline-secondary btn-sm btn-month">Gru</a>
                <!-- Next month -->
                <a href="?y=2024&m=12" id="nextMonth" class="btn btn-secondary btn-sm ms-2" title="Następny"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16"><path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/></svg></a>
            </div>
            <div class="select-date">
                <!-- Calendar button for year and month selection -->
                <input type="text" id="datePicker" class="form-control d-inline-block" style="width: 150px;text-align:center;" placeholder="Wybierz datę" value="<?=$calendar->getYear();?>-<?=$calendar->getMonth();?>">
            </div>
        </div>
        <div id="calendarHolder">
            <div class="calendar-today">
                <div class="calendar-today-month-day">
                    <?=date('j'); ?>
                </div>
                <div class="calendar-today-month-year">
                    <?=strftime('%b %Y', strtotime(date('Y-m-d'))); ?>
                </div>
            </div>
            <div class="calendar-current-hour">
                <div id="calendarCurrentHour"></div>
            </div>
        </div>
    </div>
    <?=$renderedCalendar->render(); ?>
</div>

<script src="./jquery-3.6.0.min.js"></script>
<!-- Zebra_DatePicker JavaScript -->
<script src="./zebra_datepicker.min.js"></script>
<script>
    let currentYear = <?php echo $calendar->getYear(); ?>;
    let currentMonth = <?php echo $calendar->getMonth(); ?>;
    const buttonsMonth = document.querySelectorAll('.btn-month');

    for (let i = 0; i < buttonsMonth.length; i++) {
        const button = buttonsMonth[i];

        // console.log(currentMonth);

        if (currentMonth === parseInt(button.getAttribute('data-month'))) {
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-primary');
        } else {
            button.classList.remove('btn-primary');
            button.classList.add('btn-outline-secondary');
        }

        button.addEventListener('click', () => {
            currentMonth = parseInt(button.getAttribute('data-month'));

            updateCalendarDisplay(button);
        });
    }

    function updateCalendarDisplay(button) {
        // alert('Wybrano: ' + button.getAttribute('data-month'));
    }

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth = (currentMonth - 1) || 12;
        currentYear -= currentMonth === 12 ? 1 : 0;
        updateCalendarDisplay();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth = (currentMonth + 1) % 12 || 1;
        currentYear += currentMonth === 1 ? 1 : 0;
        updateCalendarDisplay();
    });

    document.querySelectorAll('.month-select').forEach(button => {
        button.addEventListener('click', () => {
            currentMonth = parseInt(button.getAttribute('data-month'));
            updateCalendarDisplay();
        });
    });

    $('#datePicker').Zebra_DatePicker({
        direction: ['2020-01', '2100-12'],
        format: 'Y-m',
        lang_clear_date: '', 
        months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
        offset: [20, 250], 
        // onSelect: function(view, elements) {
        //    window.location.href = '/experiments-php/horizontal-calendar/index.php?m='+view;
        // },
        onSelect: function(view, elements) {
            const [year, month] = view.split('-');
            currentYear = parseInt(year);
            currentMonth = parseInt(month);
            updateCalendarDisplay();

            alert('Wybrano: ' + view);
        }
    });

    function getCurrentTimeInWarsaw() {
        // Get current time for zone Europe/Warsaw.
        const now = new Date().toLocaleString("pl-PL", {
            timeZone: "Europe/Warsaw",
            hour: "numeric",
            minute: "2-digit",
            second: "2-digit",
            hour12: false // Format 24-hours
        });

        return now;
    }

    function displayTime() {
        const timeElement = document.getElementById("calendarCurrentHour");
        timeElement.textContent = getCurrentTimeInWarsaw();
    }

    // Set interval that calll function displayTime every 1 second.
    setInterval(displayTime, 1000);

    // Start displayTime on page.
    displayTime();
</script>
</body>
</html>
