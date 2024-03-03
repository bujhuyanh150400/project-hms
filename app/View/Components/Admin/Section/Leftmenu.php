<?php

namespace App\View\Components\Admin\Section;

use App\Helper\PermissionAdmin;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Leftmenu extends Component
{
    protected $arrayLeftMenu = [];

    public function __construct()
    {
        $user = Auth::guard('admin')->user();
        switch ($user->permission) {
            case PermissionAdmin::ADMIN:
                $this->arrayLeftMenu = [
                    [
                        'title' => 'Thống kê',
                        'icon' => '<i class="bi bi-clipboard-data"></i>',
                        'action' => route('admin.dashboard'),
                        'route_name' => 'admin'
                    ],
                    [
                        'title' => 'Điều hành',
                        'space_menu' => true,
                    ],
                    [
                        'title' => 'Nhân lực',
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
                        'title' => 'Quản lý thuốc',
                        'icon' => '<i class="bi bi-box-seam"></i>',
                        'sub_menu' => [
                            [
                                'title' => 'Loại vật tư',
                                'route_name' => 'type_material',
                                'action' => route('type_material.list'),
                            ],
                            [
                                'title' => 'Vật tư',
                                'route_name' => 'warehouse',
                                'action' => route('warehouse.list'),
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
                break;
            case PermissionAdmin::MANAGER:
                $this->arrayLeftMenu = [
                    [
                        'title' => 'Thống kê',
                        'icon' => '<i class="bi bi-clipboard-data"></i>',
                        'action' => route('admin.dashboard'),
                        'route_name' => 'admin'
                    ],
                    [
                        'title' => 'Điều hành',
                        'space_menu' => true,
                    ],
                    [
                        'title' => 'Nhân lực',
                        'icon' => '<i class="bi bi-hospital-fill"></i>',
                        'sub_menu' => [
                            [
                                'title' => 'Nhân sự',
                                'route_name' => 'users',
                                'action' => route('users.list'),

                            ],
                            [
                                'title' => 'Thông tin cơ sở',
                                'route_name' => 'clinic',
                                'action' => route('clinic.view', ['id' => $user->clinic_id]),
                            ],
                            [
                                'title' => 'Chuyên khoa',
                                'route_name' => 'specialties',
                                'action' => route('specialties.list'),
                            ],
                        ]
                    ],
                    [
                        'title' => 'Quản lý thuốc',
                        'icon' => '<i class="bi bi-box-seam"></i>',
                        'sub_menu' => [
                            [
                                'title' => 'Loại vật tư',
                                'route_name' => 'type_material',
                                'action' => route('type_material.list'),
                            ],
                            [
                                'title' => 'Vật tư',
                                'route_name' => 'warehouse',
                                'action' => route('warehouse.list'),
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
                break;
            case PermissionAdmin::DOCTOR:
                $this->arrayLeftMenu = [
                    [
                        'title' => 'Thống kê',
                        'icon' => '<i class="bi bi-clipboard-data"></i>',
                        'action' => route('admin.dashboard'),
                        'route_name' => 'admin'
                    ],
                    [
                        'title' => 'Điều hành',
                        'space_menu' => true,
                    ],
                    [
                        'title' => 'Cơ sở hiện tại',
                        'icon' => '<i class="bi bi-hospital-fill"></i>',
                        'sub_menu' => [
                            [
                                'title' => 'Thông tin cá nhân',
                                'route_name' => 'users',
                                'action' => route('users.view', ['id' => $user->id]),

                            ],
                            [
                                'title' => 'Cơ sở trực thuộc',
                                'route_name' => 'clinic',
                                'action' => route('clinic.view', ['id' => $user->clinic->id]),
                            ],
                            [
                                'title' => 'Chuyên khoa',
                                'route_name' => 'specialties',
                                'action' => route('specialties.list'),
                            ],
                        ]
                    ],
                    [
                        'title' => 'Kho thuốc',
                        'icon' => '<i class="bi bi-box-seam"></i>',
                        'action' => route('warehouse.list'),
                        'route_name' => 'warehouse'
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
                        'title' => 'Giờ làm cá nhân',
                        'icon' => '<i class="bi bi-alarm"></i>',
                        'action' => route('bookings.list', ['user_id' => $user->id]),
                        'route_name' => 'bookings'
                    ],
                    [
                        'title' => 'Lịch khám cá nhân',
                        'icon' => '<i class="bi bi-card-list"></i>',
                        'action' => route('schedules.list', ['user_id' => $user->id]),
                        'route_name' => 'schedules'
                    ],
                ];
                break;
            case PermissionAdmin::TAKE_CARE:
                $this->arrayLeftMenu = [
                    [
                        'title' => 'Thống kê',
                        'icon' => '<i class="bi bi-clipboard-data"></i>',
                        'action' => route('admin.dashboard'),
                        'route_name' => 'admin'
                    ],
                    [
                        'title' => 'Điều hành',
                        'space_menu' => true,
                    ],
                    [
                        'title' => 'Cơ sở hiện tại',
                        'icon' => '<i class="bi bi-hospital-fill"></i>',
                        'sub_menu' => [
                            [
                                'title' => 'Thông tin cá nhân',
                                'route_name' => 'users',
                                'action' => route('users.view', ['id' => $user->id]),

                            ],
                            [
                                'title' => 'Cơ sở trực thuộc',
                                'route_name' => 'clinic',
                                'action' => route('clinic.view', ['id' => $user->clinic->id]),
                            ],
                            [
                                'title' => 'Chuyên khoa',
                                'route_name' => 'specialties',
                                'action' => route('specialties.list'),
                            ],
                        ]
                    ],
                    [
                        'title' => 'Kho thuốc',
                        'icon' => '<i class="bi bi-box-seam"></i>',
                        'action' => route('warehouse.list'),
                        'route_name' => 'warehouse'
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
                        'title' => 'Giờ làm các bác sĩ',
                        'icon' => '<i class="bi bi-alarm"></i>',
                        'action' => route('bookings.all_bookings'),
                        'route_name' => 'bookings'
                    ],
                    [
                        'title' => 'Quản lý lịch khám cơ sở',
                        'icon' => '<i class="bi bi-card-list"></i>',
                        'action' => route('schedules.all_schedules'),
                        'route_name' => 'schedules'
                    ],
                ];
                break;
        }
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
