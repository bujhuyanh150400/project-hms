<?php

namespace App\Helper;

class TimeType
{
    const TIME1 = 15;
    const TIME2 = 16;
    const TIME3 = 17;
    const TIME4 = 18;
    const TIME5 = 19;
    const TIME6 = 20;
    const TIME7 = 21;
    const TIME8 = 22;
    static function getList()
    {
        return [
            self::TIME1 => [
                'value' => self::TIME1,
                'start' => '8:00',
                'end' => '9:00'
            ],
            self::TIME2 => [
                'value' => self::TIME2,
                'start' => '9:00',
                'end' => '10:00'
            ],
            self::TIME3 => [
                'value' => self::TIME3,
                'start' => '10:00',
                'end' => '11:00'
            ],
            self::TIME4 => [
                'value' => self::TIME4,
                'start' => '11:00',
                'end' => '12:00'
            ],
            self::TIME5 => [
                'value' => self::TIME5,
                'start' => '13:00',
                'end' => '14:00'
            ],
            self::TIME6 => [
                'value' => self::TIME6,
                'start' => '14:00',
                'end' => '15:00'
            ],
            self::TIME7 => [
                'value' => self::TIME7,
                'start' => '15:00',
                'end' => '16:00'
            ],
            self::TIME8 => [
                'value' => self::TIME8,
                'start' => '16:00',
                'end' => '17:00'
            ]
        ];
    }
}
