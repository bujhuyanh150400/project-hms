<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Usercontroller\ListRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    private const PER_PAGE = 10;

    public function __construct()
    {
    }

    public function list(ListRequest $request)
    {
        $title = "Danh sách nhân sự";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $users = User::KeywordFilter($filter->get('keyword'))
            ->RoleFilter($filter->get('role'))
            ->CreatedAtFilter($filter->get('start_date_create') ?? '', $filter->get('end_date_create'))
            ->paginate($limit);
        return view('Admin.Users.list', compact('title', 'users', 'filter'));
    }
}
