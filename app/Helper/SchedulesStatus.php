<?php

namespace App\Helper;


class SchedulesStatus
{
    const ON_SCHEDULES = 15;
    const ON_GOING = 16;
    const SUCCESS = 17;
    const FAILED = 18;

    static function getList()
    {
        return [
            self::ON_SCHEDULES => [
                'value' => self::ON_SCHEDULES,
                'text' => 'Chờ đến khám'
            ],
            self::ON_GOING => [
                'value' => self::ON_GOING,
                'text' => 'Đã đến khám'
            ],
            self::FAILED => [
                'value' => self::FAILED,
                'text' => 'Khám thất bại'
            ],
            self::SUCCESS => [
                'value' => self::SUCCESS,
                'text' => 'Đã khám xong'
            ],
        ];
    }
}
