<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerHasAnimal
{
    public function handle(Request $request, Closure $next): Response
    {
        $customer = Customer::find($request->route('customer_id'));
        if (!$customer) {
            session()->flash('error', 'Khách hàng không có trong hệ thống');
            return redirect()->route('customer.list');
        }
        if ($customer->animal->isEmpty()) {
            session()->flash('error', 'Khách hàng này chưa khai báo thú cưng');
            return redirect()->route('animal.view_add', ['cust_id' => $customer->id]);
        }
        return $next($request);
    }
}
