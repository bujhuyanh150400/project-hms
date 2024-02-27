@extends('Admin.Layout.index')
@section('title', $title)
@section('body')
    {{-- Navigation --}}
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 max-w-fit mb-4"
        aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="bi bi-house-door-fill"></i>
                    Trang chủ
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">{{ $title }}:
                        {{ $clinic->name }}</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    {{-- Header + Avatar --}}
    <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm mb-4 p-4">
        <div class="flex items-center justify-between ">
            <div class="flex items-center gap-4">
                <img class="w-24 h-24 rounded border border-gray-300 shadow-md"
                    @if (!empty($clinic->avatar)) src="{{ route('file.show', ['filepath' => $clinic->avatar]) }}"
                                    @else
                                        src="{{ asset('assets/images/clinic.png') }}" @endif
                    alt="avatar logo" />
                <div class="flex items-start gap-2 flex-col">
                    <h5 class="text-xl font-medium text-gray-900">{{ $clinic->name }}</h5>
                    <div class="flex items-center gap-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="w-full h-fit bg-white border border-gray-200 rounded-lg shadow-md mb-4 p-4">
            <h1 class="text-xl font-medium">Thông tin nhân sự:</h1>
            <dl class=" text-gray-900 divide-y divide-gray-200 ">
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Địa chỉ:</dt>
                    <dd class="font-semibold"> {{ $clinic->address_data }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Trạng thái:</dt>
                    <dd class="font-semibold"> {{ $clinic->active === 1 ? 'Đang hoạt động' : 'Dừng hoạt động' }}</dd>
                </div>
            </dl>

        </div>
        <div class="w-full h-fit bg-white border border-gray-200 rounded-lg shadow-md mb-4 p-4">
            <h1 class="text-xl font-medium mb-4">Giới thiệu về cơ sở:</h1>
            {!! $clinic->description !!}
        </div>
    </div>
@endsection
