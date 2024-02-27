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
            @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER)
                <li>
                    <a href="{{ route('users.list') }}" class="flex items-center">
                        <i class="bi bi-chevron-right"></i>
                        <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách nhân sự</span>
                    </a>
                </li>
            @endif
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">{{ $title }}:
                        {{ $user->name }}</span>
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
                    @if (!empty($user->avatar)) src="{{ route('file.show', ['filepath' => $user->avatar]) }}"
                                    @else
                                        src="{{ asset('assets/images/user-admin.png') }}" @endif
                    alt="avatar logo" />
                <div class="flex items-start gap-2 flex-col">
                    <h5 class="text-xl font-medium text-gray-900">{{ $user->name }}</h5>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Role:
                            <span class="font-bold text-sm">
                                @isset(PermissionAdmin::getList()[$user->permission])
                                    {{ PermissionAdmin::getList()[$user->permission]['text'] }}
                                @endisset
                            </span>
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Cấp bậc:
                            <span class="font-bold text-sm">
                                @isset(UserStatus::getList()[$user->user_status])
                                    {{ UserStatus::getList()[$user->user_status]['text_vn'] }}
                                @endisset
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER)
                    <a href="{{ route('users.list') }}" class="btn-custom btn-default">
                        <i class="bi bi-arrow-left"></i> Quay lại</a>
                @endif
                <a href="{{ route('users.view_edit', ['id' => $user->id]) }}" class="btn-custom btn-primary"><i
                        class="bi bi-pencil-square"></i> Chỉnh sửa</a>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="w-full h-fit bg-white border border-gray-200 rounded-lg shadow-md mb-4 p-4">
            <h1 class="text-xl font-medium">Thông tin nhân sự:</h1>
            <dl class=" text-gray-900 divide-y divide-gray-200 ">
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Email:</dt>
                    <dd class="font-semibold">{{ $user->email }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">SĐT:</dt>
                    <dd class="font-semibold">{{ $user->phone }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Nơi ở:</dt>
                    <dd class="font-semibold">{{ $user->address }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Ngày sinh:</dt>
                    <dd class="font-semibold">{{ \Carbon\Carbon::parse($user->birth)->format('d-m-Y') }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Giới tính:</dt>
                    <dd class="font-semibold">{{ $user->gender === 1 ? 'Nam' : 'Nữ' }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Cơ sở trực thuộc:</dt>
                    <dd class="font-semibold">{{ $user->clinic->name }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Chuyên ngành:</dt>
                    <dd class="font-semibold">{{ $user->specialties->name }}</dd>
                </div>
                <div class="flex flex-col py-2">
                    <dt class="mb-1 text-gray-500">Giá khám mặc định mỗi lần khám:</dt>
                    <dd class="font-semibold">{{ number_format($user->examination_price) }} VNĐ</dd>
                </div>
            </dl>

        </div>
        <div class="w-full h-fit bg-white border border-gray-200 rounded-lg shadow-md mb-4 p-4">
            <h1 class="text-xl font-medium mb-4">Giới thiệu bản thân nhân sự:</h1>
            {!! $user->description !!}
        </div>
    </div>
@endsection
