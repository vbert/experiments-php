<?php
/*
 * Project: VbCalendar/EventObject
 * File: /Color.php
 * File Created: 2024-11-22, 9:30:44
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-22, 10:02:55
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\EventObject;


class Color {
    private static int $colorId = 0;
    private array $colors = [];


    public function __construct($colors=[]) {
        $this->colors = count($colors) > 0 ? $colors : $this->defaultColors();
    }

    public function getColor($colorId=null): string {

        if ($colorId !== null && $colorId < count($this->colors)) {
            self::$colorId = $colorId;
            $color = $this->colors[$colorId];
        } else {
            $color = $this->colors[self::$colorId];
        }

        self::$colorId++;

        if (self::$colorId >= count($this->colors)) {
            self::$colorId = 0;
        }

        return $color;
    }

    public static function get($colorId=null) {
        return (new self())->getColor($colorId);
    }

    public function setColors(array $colors): void {
        $this->colors = $colors;
    }

    private function defaultColors(): array {
        return [
            '#0d6efd',
            '#6610f2',
            '#6f42c1',
            '#d63384',
            '#dc3545',
            '#fd7e14',
            '#ffc107',
            '#198754',
            '#20c997',
            '#0dcaf0'
        ];
    }
}
