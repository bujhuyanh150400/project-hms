<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    const FILE_PATH_ADMIN = 'file_storage/admin/';



    protected function getIdAsTimestamp(): int
    {
        return date('ymdHis') . rand(10, 99);
    }
    protected function storageFileAdmin($requestFile, $name){

    }
}
