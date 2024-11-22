<?php
/*
 * Project: VbCalendar/Adapters
 * File: /AdapterDataInterface.php
 * File Created: 2024-11-22, 11:36:03
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-22, 12:05:00
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Adapters;

interface AdapterDataInterface {
    public function getData(array $data): array;
    public function setData(array $data): array;
}
