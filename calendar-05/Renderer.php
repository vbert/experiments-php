<?php
/*
 * Project: calendar-05
 * File: /Renderer.php
 * File Created: 2024-06-15, 21:25:40
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-10-17, 14:41:45
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */
namespace vbert\experiments\calendar05;

interface CalendarRendererInterface {
    public function render(CalendarInterface $calendar, $year = null, $month = null, $day = null);
}

class MonthlyTemplateRenderer implements CalendarRendererInterface {
    private $template;

    public function __construct(Template $template) {
        $this->template = $template;
    }

    public function render(CalendarInterface $calendar, $year = null, $month = null, $day = null) {
        $data = $calendar->generate();
        return $this->template->render('monthly', ['data' => $data, 'year' => $year, 'month' => $month]);
    }
}

class WeeklyTemplateRenderer implements CalendarRendererInterface {
    private $template;

    public function __construct(Template $template) {
        $this->template = $template;
    }

    public function render(CalendarInterface $calendar, $year = null, $month = null, $day = null) {
        $data = $calendar->generate();
        return $this->template->render('weekly', ['data' => $data, 'year' => $year, 'month' => $month, 'day' => $day]);
    }
}

class YearlyTemplateRenderer implements CalendarRendererInterface {
    private $template;

    public function __construct(Template $template) {
        $this->template = $template;
    }

    public function render(CalendarInterface $calendar, $year = null, $month = null, $day = null) {
        $data = $calendar->generate();
        return $this->template->render('yearly', ['data' => $data, 'year' => $year]);
    }
}

class CalendarView {
    private $calendar;
    private $renderer;

    public function __construct(CalendarInterface $calendar, CalendarRendererInterface $renderer) {
        $this->calendar = $calendar;
        $this->renderer = $renderer;
    }

    public function render($year = null, $month = null, $day = null) {
        return $this->renderer->render($this->calendar, $year, $month, $day);
    }
}
