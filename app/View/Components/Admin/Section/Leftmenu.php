<?php

namespace App\View\Components\Admin\Section;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Leftmenu extends Component
{
    protected $arrayLeftMenu = [];

    public function __construct()
    {
        $this->arrayLeftMenu = [
            [
                'title' => 'Trang chủ',
                'icon' => '<i class="bi bi-clipboard-data"></i>',
                'action' => route('admin.dashboard'),
                'route_name' => 'admin'
            ],
            [
                'title' => 'Điều hành',
                'space_menu' => true,
            ],
            [
                'title' => 'Quản lý',
                'icon' => '<i class="bi bi-hospital-fill"></i>',
                'sub_menu' => [
                    [
                        'title' => 'Nhân sự',
                        'route_name' => 'users',
                        'action' => route('users.list'),

                    ],
                    [
                        'title' => 'Cơ sở khám bệnh',
                        'route_name' => 'clinic',
                        'action' => route('clinic.list'),
                    ],
                    [
                        'title' => 'Chuyên khoa',
                        'route_name' => 'specialties',
                        'action' => route('specialties.list'),
                    ],
                ]
            ],
            [
                'title' => 'Khách hàng',
                'space_menu' => true,
            ],
            [
                'title' => 'Quản lý khách hàng',
                'icon' => '<i class="bi bi-people"></i>',
                'action' => route('customer.list'),
                'route_name' => 'customer'
            ],
            [
                'title' => 'Quản lý thú cưng',
                'icon' => '<i class="bi bi-bookmark-heart-fill"></i>',
                'action' => route('animal.list'),
                'route_name' => 'animal'
            ],
            [
                'title' => 'Quản lí khám bệnh',
                'space_menu' => true,
            ],
            [
                'title' => 'Quản lý lịch làm',
                'icon' => '<i class="bi bi-alarm"></i>',
                'action' => route('bookings.find_list'),
                'route_name' => 'bookings'
            ],
            [
                'title' => 'Quản lý lịch khám',
                'icon' => '<i class="bi bi-card-list"></i>',
                'action' => route('schedules.find_list'),
                'route_name' => 'schedules'
            ],
        ];
    }

    public function render(): View|Closure|string
    {
        $route_name = Route::currentRouteName();
        $parts = explode('.', $route_name);
        $current_route = reset($parts);
        return view('components.admin.section.leftmenu', [
            'list_menu' => $this->arrayLeftMenu,
            'current_route' => $current_route,
        ]);
    }
}
