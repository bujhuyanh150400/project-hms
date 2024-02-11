<?php

namespace App\Helper;

class PermissionAdmin
{
    const ADMIN = 16;
    const DOCTOR = 12;
    const CUSTOMER_CARE = 99;

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
            self::CUSTOMER_CARE => [
                'value' => self::CUSTOMER_CARE,
                'text' => 'Nhân viên chăm sóc'
            ],
        ];
    }
}
