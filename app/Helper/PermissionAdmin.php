<?php

namespace App\Helper;

class PermissionAdmin
{
    const ADMIN = 16;
    const DOCTOR = 12;
    const TAKE_CARE = 15;
    const MANAGER = 04;


    static function getList()
    {
        return [
            self::ADMIN => [
                'value' => self::ADMIN,
                'text' => 'Điều hành hệ thống'
            ],
            self::MANAGER => [
                'value' => self::MANAGER,
                'text' => 'Quản lý cơ sở'
            ],
            self::DOCTOR => [
                'value' => self::DOCTOR,
                'text' => 'Bác sĩ'
            ],
            self::TAKE_CARE => [
                'value' => self::TAKE_CARE,
                'text' => 'Bộ phận take care'
            ],
        ];
    }
}
