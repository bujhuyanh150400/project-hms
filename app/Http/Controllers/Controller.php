<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function __construct()
    {
    }

    protected function getUserLogin()
    {
        return Auth::guard('admin')->user();
    }

    const FILE_PATH_ADMIN = 'file_storage/admin/';

    const FILE_PATH = 'file_storage';

    protected function getIdAsTimestamp(): int
    {
        return intval(date('ymdHis') . rand(10, 99));
    }
}
