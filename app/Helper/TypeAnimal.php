<?php

namespace App\Helper;

class TypeAnimal
{
    const CAT = 16;
    const DOG = 15;

    static function getList()
    {
        return [
            self::CAT => [
                'value' => self::CAT,
                'text' => 'Mèo'
            ],
            self::DOG => [
                'value' => self::DOG,
                'text' => 'Chó'
            ],
        ];
    }
}
