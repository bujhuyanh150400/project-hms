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
                'icon' => '<i class="bi bi-speedometer2"></i>',
                'action' => route('admin.dashboard'),
                'route_name' => 'admin'
            ],
            [
                'title' => 'Quản lý nhân sự',
                'space_menu' => true,
            ],
            [
                'title' => 'Quản lý nhân sự',
                'icon' => '<i class="bi bi-people"></i>',
                'sub_menu' => [
                    [
                        'title' => 'Quản lý nhân sự',
                        'route_name' => 'users',
                        'action' => route('admin.dashboard'),

                    ],
                ]
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
