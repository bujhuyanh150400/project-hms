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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách chuyên
                        khoa</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    {{-- Search --}}
    <form action="{{ route('specialties.list') }}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-4 gap-3 mb-3">

                <div class="form-group">
                    <label class="form-label" for="simple-search">Tìm kiếm</label>
                    <input type="text" class="form-input" name="filter[keyword]" id="keyword"
                        value="{{ old('filter.keyword', $filter['keyword'] ?? '') }}"
                        placeholder="Tìm kiếm theo tên , theo ID">
                </div>
                <div class="form-group">
                    <label class="form-label" for="active">Trạng thái</label>
                    <select id="active" name="filter[active]" class="form-input">
                        <option value="">Chọn</option>
                        <option value="1" {{ old('filter.active', $filter['active'] ?? '') == 2 ? 'selected' : '' }}>
                            Mở</option>
                        <option value="2" {{ old('filter.active', $filter['active'] ?? '') == 1 ? 'selected' : '' }}>
                            Không mở</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm kiếm</button>
                @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER)
                    <a href="{{ route('specialties.view_add') }}" class="btn-custom btn-success"><i
                            class="bi bi-plus"></i>Thêm</a>
                @endif
            </div>
        </div>
    </form>
    {{-- End:Search --}}
    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($specialties) and count($specialties) > 0)
            <x-admin.table>
                <x-slot:header>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Tên chuyên khoa
                        </th>
                        <th>
                            Logo
                        </th>
                        <th>
                            Trạng thái
                        </th>
                        <th>
                            Mô tả
                        </th>
                        @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER)
                            <th>
                                Action
                            </th>
                        @endif
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach ($specialties as $specialty)
                        <tr>
                            <td>
                                {{ $specialty->id }}
                            </td>
                            <td>
                                {{ $specialty->name }}
                            </td>
                            <td>
                                <img class="w-10 h-10 rounded"
                                    @if (!empty($specialty->logo)) src="{{ route('file.show', ['filepath' => $specialty->logo]) }}"
                                    @else
                                        src="{{ asset('assets/images/clinic.png') }}" @endif
                                    alt="clinic logo" />
                            </td>
                            <td>
                                {{ $specialty->active === 1 ? 'Đang hoạt động' : 'Dừng hoạt động' }}
                            </td>
                            <td>
                                <div class="max-h-[200px] overflow-y-auto">
                                    {!! $specialty->description !!}
                                </div>
                            </td>
                            @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER)
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('specialties.view_edit', ['id' => $specialty->id]) }}"
                                            class="btn-custom btn-icon btn-primary">
                                            <i class="bi bi-pen-fill "></i>
                                        </a>
                                        <form action="{{ route('specialties.deleted', ['id' => $specialty->id]) }}"
                                            method="POST" class="form-loading-submit">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-custom btn-icon btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-admin.table>
            {!! $specialties->links() !!}
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
