<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Provinces extends Component
{
    public function __construct(
        public string $province,
        public string $district,
        public string $ward,
        public string $address,
        public mixed $object = null,
    ) {
    }
    public function render(): View|Closure|string
    {
        return view('components.admin.provinces');
    }
}
