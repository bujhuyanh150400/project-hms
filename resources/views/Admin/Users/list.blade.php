@extends('Admin.Layout.index')
@section('title', $title)

@section('body')
    {{-- Navigation --}}
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 max-w-fit" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <i class="bi bi-house-door-fill"></i>
                    Trang chủ
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách nhân sự</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    {{-- Search --}}
    <form action="{{ route('users.list') }}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-4 gap-3 mb-3">

                <div class="form-group">
                    <label class="form-label" for="simple-search">Tìm kiếm</label>
                    <input type="text" class="form-input" name="filter[keyword]" id="keyword"
                        value="{{ old('filter.keyword', $filter['keyword'] ?? '') }}"
                        placeholder="Tìm kiếm theo tên , email">
                </div>
                <div class="form-group">
                    <label class="form-label" for="role">Tìm theo Chức vụ</label>
                    <select id="role" name="filter[role]" class="form-input">
                        <option value="">Chọn chức vụ</option>
                        @foreach (PermissionAdmin::getList() as $permission)
                            <option value="{{ $permission['value'] }}"
                                {{ old('filter.role', $filter['role'] ?? '') == $permission['value'] ? 'selected' : '' }}>
                                {{ $permission['text'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tìm theo ngày tạo</label>
                    <div date-rangepicker class="flex items-center space-x-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input name="filter[start_date_create]" type="text"
                                value="{{ old('filter.start_date_create', $filter['start_date_create'] ?? '') }}"
                                class="form-input-icon datepicker" placeholder="Từ ngày">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input name="filter[end_date_create]"
                                value="{{ old('filter.end_date_create', $filter['end_date_create'] ?? '') }}" type="text"
                                class="form-input-icon datepicker" placeholder="Đến ngày">
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm kiếm</button>
                <a href="{{ route('users.view_add') }}" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</a>
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
                        <th width='80'>
                            ID
                        </th>
                        <th>
                            Avatar
                        </th>
                        <th>
                            Tên nhân viên
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Chức vụ
                        </th>
                        <th>
                            Cơ sở
                        </th>
                        <th>
                            Chuyên ngành
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td class="text-center align-middle">
                                <div class="flex items-center justify-center">
                                    <img class="w-10 h-10 rounded-full ring-1 shadow-lg ring-gray-300"
                                        @if (!empty($user->avatar)) src="{{ route('file.show', ['filepath' => $user->avatar]) }}"
                                    @else
                                        src="{{ asset('assets/images/user-admin.png') }}" @endif
                                        alt="avatar logo" />
                                </div>
                            </td>
                            <td class="text-start align-middle font-bold">
                                {{ $user->name }}
                            </td>
                            <td class="text-start align-middle">
                                {{ $user->email }}
                            </td>
                            <td class="text-center align-middle">
                                @isset(PermissionAdmin::getList()[$user->permission])
                                    {{ PermissionAdmin::getList()[$user->permission]['text'] }}
                                @endisset
                            </td>
                            <td>
                                {{ $user->clinic->name }}
                            </td>
                            <td>
                                {{ $user->specialties->name }}
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('users.view', ['id' => $user->id]) }}"
                                        class="btn-custom btn-icon btn-success">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                    <a href="{{ route('users.view_edit', ['id' => $user->id]) }}"
                                        class="btn-custom btn-icon btn-primary">
                                        <i class="bi bi-pen-fill"></i>
                                    </a>
                                    <form action="{{ route('users.deleted', ['id' => $user->id]) }}" method="POST"
                                        class="form-loading-submit">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-custom btn-icon btn-danger">
                                            <i class="bi bi-trash-fill "></i>
                                        </button>
                                    </form>
                                </div>
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
@section('scripts')
@endsection
