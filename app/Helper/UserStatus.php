<?php

namespace App\Helper;


class UserStatus
{
    const PROFESSOR = 15;
    const ASSOCIATE_PROFESSOR = 16;
    const DIRECTOR = 17;
    const EMPLOYEE = 18;

    static function getList()
    {
        return [
            self::PROFESSOR => [
                'value' => self::PROFESSOR,
                'text_vn' => 'Giáo sư'
            ],
            self::ASSOCIATE_PROFESSOR => [
                'value' => self::ASSOCIATE_PROFESSOR,
                'text_vn' => 'Phó giáo sư'
            ],
            self::DIRECTOR => [
                'value' => self::DIRECTOR,
                'text_vn' => 'Bác sĩ chuyên khoa'
            ],
            self::EMPLOYEE => [
                'value' => self::EMPLOYEE,
                'text_vn' => 'Nhân viên'
            ],
        ];
    }
}
