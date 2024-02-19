<?php

namespace App\Helper;

class PermissionAdmin
{
    const ADMIN = 16;
    const DOCTOR = 12;

    static function getList()
    {
        return [
            self::ADMIN => [
                'value' => self::ADMIN,
                'text' => 'Quản lý'
            ],
            self::DOCTOR => [
                'value' => self::DOCTOR,
                'text' => 'Bác sĩ'
            ],
        ];
    }
}
