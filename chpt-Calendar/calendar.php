<?php
/*
 * Project: chptCalendar-02
 * File: /calendar.php
 * File Created: 2024-10-29, 9:36:40
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-29, 14:53:44
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

    public function getUrlEditEvent(): string {
        return "/edit_event.php?id=" . $this->id;
    }

    public function getUrlAddEvent(): string {
        return "/add_event.php?id=" . $this->id;
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
    private string $dayName;
    
    public function __construct(int $year, int $month, int $day) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->dayName = date('D', strtotime("$year-$month-$day"));
    }

    public function getDate(): string {
        return "{$this->year}-{$this->month}-{$this->day}";
    }

    public function getDayName(): string {
        return $this->dayName;
    }

    public function isWeekend(): bool {
        return in_array($this->dayName, ['Sat', 'Sun']);
    }
}


class CalendarRenderer {
    private Calendar $calendar;
    private array $objects;

    public function __construct(Calendar $calendar, array $objects) {
        $this->calendar = $calendar;
        $this->objects = $objects;
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
        $html = '<tr><th class="monthdays" rowspan="2">Narty</th>';

        foreach ($this->calendar->getDays() as $day) {
            $dayNumber = (int)date('j', strtotime($day->getDate())); 
            $fullDate = $day->getDate();
            $dayClass = $day->isWeekend() ? " class='weekend'" : "";
            $html .= "<th{$dayClass} data-day='{$fullDate}'>{$dayNumber}</th>";
        }

        $html .= "</tr>";
        return $html;
    }

    private function renderDayNames(): string {
        $html = '<tr class="weekdays">';

        foreach ($this->calendar->getDays() as $day) {
            $dayName = $day->getDayName();
            $dayClass = $day->isWeekend() ? " class='weekend'" : "";
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
                $colspan = $this->calculateColspan($event, $i);
                $color = $object->getColor();
                $eventName = $this->getFormattedEventName($event, $day);
                
                $html .= "<td colspan='{$colspan}' style='background-color:{$color};'><a href='{$object->getUrlEditEvent()}'>{$eventName}</a></td>";
                $i += $colspan - 1;
            } else {
                $html .= "<td></td>";
            }
        }

        $html .= "</tr>";
        return $html;
    }

    private function getEventForDay(GeneralObject $object, CalendarDay $day): ?Event {

        foreach ($object->getEvents() as $event) {
            if ($event->occursOn($day)) {
                return $event;
            }
        }
        return null;
    }

    private function calculateColspan(Event $event, int $startIndex): int {
        $startDate = $event->getStartDate();
        $endDate = $event->getEndDate();
        $colspan = 1;

        for ($i = $startIndex + 1; $i < count($this->calendar->getDays()); $i++) {
            $currentDay = $this->calendar->getDays()[$i];
            $currentDate = new DateTime($currentDay->getDate());

            if ($currentDate > $endDate) {
                break;
            }
            $colspan++;
        }

        return $colspan;
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
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Calendar</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Zebra_DatePicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/2.0.0/css/bootstrap/zebra_datepicker.min.css" integrity="sha512-T7fd/iXI/NUTH7dKF+ADcO/fKgC2Y2r6DE3pAPX7Yat968wE8s2v2+L3m2Y4MAYifaQOF/+ewUmOCF/Dr3x3NA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- style.css -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">

<div class="my-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <span class="h5" id="currentDateDisplay"></span>
        <div>
            <button id="prevMonth" class="btn btn-secondary btn-sm me-2">Previous</button>
            <!-- Quick month selection buttons -->
            <button data-month="1" class="btn btn-outline-secondary btn-sm month-select">Jan</button>
            <button data-month="2" class="btn btn-outline-secondary btn-sm month-select">Feb</button>
            <button data-month="3" class="btn btn-outline-secondary btn-sm month-select">Mar</button>
            <button data-month="4" class="btn btn-outline-secondary btn-sm month-select">Apr</button>
            <button data-month="5" class="btn btn-outline-secondary btn-sm month-select">May</button>
            <button data-month="6" class="btn btn-outline-secondary btn-sm month-select">Jun</button>
            <button id="nextMonth" class="btn btn-secondary btn-sm ms-2">Next</button>
            <!-- Calendar button for year and month selection -->
            <input type="text" id="datePicker" class="form-control d-inline-block" style="width: 130px;" placeholder="Select Date">
        </div>
    </div>

    <?php
    // Set up calendar and objects
    $calendar = new Calendar(2024, 10);
    $skis1 = new Skis(1, "Skis Red", "Red colored skis for professionals.", "#ff6666");
    $skis2 = new Skis(2, "Skis Blue", "Blue colored skis for beginners.", "#6666ff");

    $event1 = new Event("Rental 1", new DateTime("2024-10-05"), new DateTime("2024-10-07"));
    $event2 = new Event("Rental 2", new DateTime("2024-10-15"), new DateTime("2024-10-18"));
    $event3 = new Event("Rental 3", new DateTime("2024-09-30"), new DateTime("2024-10-02"));
    $event4 = new Event("Rental 4", new DateTime("2024-10-30"), new DateTime("2024-11-02"));

    $skis1->addEvent($event1);
    $skis2->addEvent($event2);
    $skis1->addEvent($event3);
    $skis2->addEvent($event4);

    $renderer = new CalendarRenderer($calendar, [$skis1, $skis2]);
    echo $renderer->render();
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Zebra_DatePicker JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/2.0.0/zebra_datepicker.min.js" integrity="sha512-Qnfn6vHrOEl6m6mBMVxKUScok5y+Apdw+3tDNpdeEHlh7/uiZ7+H0VkxLlumrj9ePNcEOA/t5vV/3NgcF44QnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    let currentYear = <?php echo $calendar->getYear(); ?>;
    let currentMonth = <?php echo $calendar->getMonth(); ?>;
    document.getElementById('currentDateDisplay').textContent = `${currentYear}-${currentMonth}`;

    function updateCalendarDisplay() {
        document.getElementById('currentDateDisplay').textContent = `${currentYear}-${currentMonth}`;
        // Code to reload the calendar would go here
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
        direction: ['2013-01', '2032-12'],
        format: 'Y-m',
        lang_clear_date: '', 
        months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
        offset: [20,250], 
        // onSelect: function(view, elements) {
        //    window.location.href = '/experiments-php/horizontal-calendar/index.php?m='+view;
        // },
        onSelect: function(view, elements) {
            const [year, month] = view.split('-');
            currentYear = parseInt(year);
            currentMonth = parseInt(month);
            updateCalendarDisplay();
        }
    });
</script>
</body>
</html>
