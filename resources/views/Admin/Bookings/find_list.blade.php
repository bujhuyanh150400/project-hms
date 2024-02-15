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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Tìm kiếm giờ khám</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    {{-- Search --}}
    <form action="{{ route('bookings.find_list') }}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-4 gap-3 mb-3">
                <div class="form-group">
                    <label class="form-label" for="simple-search">Tìm nhân viên</label>
                    <input type="text" class="form-input" name="filter[keyword]" id="keyword"
                        value="{{ old('filter.keyword', $filter['keyword'] ?? '') }}"
                        placeholder="Tìm kiếm theo tên , email , ID">
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm kiếm</button>
                </div>
            </div>

        </div>
    </form>
    {{-- End:Search --}}

    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($users) and count($users) > 0)
            <x-admin.table>
                <x-slot:header>
                    <tr>
                        <th class="text-center align-middle" width='80'>
                            ID
                        </th>
                        <th class="text-center align-middle">
                            Thông tin nhân viên
                        </th>
                        <th class="text-center align-middle">
                            Chức vụ
                        </th>
                        <th class="text-center align-middle">
                            Cơ sở
                        </th>
                        <th class="text-center align-middle">
                            Chuyên khoa
                        </th>
                        <th class="text-center align-middle">
                            Action
                        </th>
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-start align-middle ">
                                {{ $user->id }}
                            </td>
                            <td class="text-start align-middle ">
                                <div class="flex flex-col gap-1">
                                    <span class="font-bold">
                                        {{ $user->name }}
                                    </span>
                                    <span class="text-sm font-italic">SĐT: {{ $user->phone }}</span>
                                    <span class="text-sm font-italic">Email: {{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="text-start align-middle">
                                @isset(PermissionAdmin::getList()[$user->permission])
                                    {{ PermissionAdmin::getList()[$user->permission]['text'] }}
                                @endisset
                            </td>
                            <td class="text-start align-middle">
                                {{ $user->clinic->name }}
                            </td>
                            <td class="text-start align-middle">
                                {{ $user->specialties->name }}
                            </td>
                            <td class="text-start align-middle">
                                <a href="{{ route('bookings.list', ['user_id' => $user->id]) }}"
                                    class="btn-custom btn-primary">
                                    <i class="bi bi-clock"></i> Xem giờ khám
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-admin.table>
            {!! $users->links() !!}
        @else
            <div class="flex items-center gap-2 p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50"
                role="alert">
                <i class="bi bi-info-circle-fill"></i>
                <div>
                    <span class="font-medium">Lưu ý!</span> Không tìm thấy dữ liệu nào cả
                </div>
            </div>
        @endif
    </div>
    {{-- End: Data list --}}
@endsection
