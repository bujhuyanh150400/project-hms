<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    //

    public function __construct()
    {
    }

    public function find_schedules($customer_id)
    {
        $customer = Customer::find($customer_id);
        if ($customer) {
            $title = 'Đặt lịch khám bệnh';
            return view('Admin.Customer.add_schedules', compact('title', 'customer'));
        } else {
            session()->flash('error', 'Khách hàng không có trong hệ thống');
            return redirect()->route('customer.list');
        }
    }

    function view_add_schedules($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $title = 'Đặt lịch khám bệnh';
            return view('Admin.Customer.add_schedules', compact('title', 'customer'));
        } else {
            session()->flash('error', 'Khách hàng không có trong hệ thống');
            return redirect()->route('customer.list');
        }
    }
}
