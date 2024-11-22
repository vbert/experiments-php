<?php
/*
 * Project: VbCalendar/Adapters
 * File: /SkiMetadataAdapter.php
 * File Created: 2024-11-22, 11:38:13
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-11-22, 12:09:04
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

namespace Vbert\VbCalendar\Adapters;

use Vbert\VbCalendar\Adapters\AdapterDataInterface;
use Vbert\VbCalendar\EventObject\Ski;

class SkiMetadataAdapter implements AdapterDataInterface {

    public function __construct() {}

    public function getData($data): array {
        $metadata = [];

        // $command = Yii::$app->db->createCommand();
        // $command->select('id, mark, model, length, description, rental_status')
        //     ->from(Skis::model()->tableName())
        //     ->where('rental_status = :rental_status', [':rental_status' => 1])
        //     ->queryAll();

        return $metadata;
    }

    public function setData(array $metadata): array {
        $data = [];

        return $data;
    }
}
