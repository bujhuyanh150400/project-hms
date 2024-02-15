<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private const PER_PAGE = 10;
    public function __construct()
    {
    }

    public function find_list(Request $request)
    {
    }

    public function list(Request $request)
    {
    }

    public function view_add(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $title = 'Thêm giờ khám';
            return view('Admin.Bookings.add', compact('title', 'user'));
        } else {
            session()->flash('error', 'Nhân viên không có trong hệ thống');
            return redirect()->route('bookings.find_list');
        }
    }
}
