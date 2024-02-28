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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách vật tư</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    {{-- Search --}}
    <form action="{{ route('warehouse.list') }}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-4 gap-3 mb-3">
                <div class="form-group">
                    <label class="form-label" for="filter[keyword]">Tìm kiếm</label>
                    <input type="text" class="form-input" name="filter[keyword]" id="filter[keyword]"
                        value="{{ old('filter.keyword', $filter['keyword'] ?? '') }}"
                        placeholder="Tìm kiếm theo tên vật tư, id ">
                </div>
                <div class="form-group">
                    <label class="form-label" for="active">Thuộc loại vật tư</label>
                    <select id="filter[type_material]" name="filter[type_material]" class="form-input">
                        <option value="">Chọn</option>
                        @foreach ($type_materials as $type)
                            <option value="{{ $type->id }}" @if ((int) old('filter.type_material', $filter['type_material'] ?? '') === $type->id) selected @endif>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if ($userLogin->permission === PermissionAdmin::ADMIN)
                    <div class="form-group">
                        <label class="form-label" for="active">Thuộc cơ sở</label>
                        <select id="filter[clinic]" name="filter[clinic]" class="form-input">
                            <option value="">Chọn</option>
                            @foreach ($clinics as $clinic)
                                <option value="{{ $clinic->id }}" @if ((int) old('filter.clinic', $filter['clinic'] ?? '') === $clinic->id) selected @endif>
                                    {{ $clinic->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm kiếm</button>
                @if ($userLogin->permission !== PermissionAdmin::DOCTOR)
                    <a href="{{ route('warehouse.view_add') }}" class="btn-custom btn-success"><i
                            class="bi bi-plus"></i>Thêm</a>
                @endif
            </div>
        </div>
    </form>
    {{-- End:Search --}}

    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($warehouses) and count($warehouses) > 0)
            <x-admin.table>
                <x-slot:header>
                    <tr>
                        <th>
                            Tên vật tư
                        </th>
                        <th>
                            Loại
                        </th>
                        <th width="150px">
                            Ảnh
                        </th>
                        <th>
                            File đính kèm
                        </th>
                        <th>
                            Mô tả
                        </th>
                        <th>
                            Số lượng trong kho
                        </th>

                        <th>
                            Thuộc cơ sở
                        </th>
                        @if (
                            $userLogin->permission === PermissionAdmin::ADMIN ||
                                $userLogin->permission === PermissionAdmin::MANAGER ||
                                $userLogin->permission === PermissionAdmin::TAKE_CARE)
                            <th>
                                Action
                            </th>
                        @endif
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach ($warehouses as $warehouse)
                        <tr>
                            <td class="text-start align-middle">
                                {{ $warehouse->name }}
                            </td>
                            <td class="text-start align-middle">
                                {{ $warehouse->type_material->name }}
                            </td>
                            <td class="text-start align-middle">
                                @if (!empty($warehouse->avatar))
                                    <img class="w-24 h-24 rounded-md ring-1 shadow-lg ring-gray-300"
                                        src="{{ route('file.show', ['filepath' => $warehouse->avatar]) }}"
                                        alt="avatar logo" />
                                @else
                                    <b class="">Vật tư ko có ảnh</b>
                                @endif
                            </td>
                            <td class="text-start align-middle">
                                @if (!empty($warehouse->file))
                                    <a class="inline-flex items-center justify-start p-2 my-2 gap-2 text-base font-medium text-blue-500 rounded-lg border border-blue-200 bg-gray-50 hover:text-blue-700 hover:bg-gray-100 "
                                        href="{{ route('file.show', ['filepath' => $warehouse->file]) }}">
                                        <i class="bi bi-file-arrow-down-fill text-xl"></i>
                                        Nhấn để download
                                    </a>
                                @else
                                    <b class="">Vật tư ko có file đính kèm</b>
                                @endif
                            </td>
                            <td class="text-start align-middle">
                                <div class="max-h-[200px] overflow-y-auto">
                                    {!! $warehouse->description !!}
                                </div>
                            </td>
                            <td class="text-start align-middle">
                                {{ $warehouse->total }}
                            </td>
                            <td class="text-start align-middle">
                                {{ $warehouse->clinic->name }}
                            </td>
                            @if (
                                $userLogin->permission === PermissionAdmin::ADMIN ||
                                    $userLogin->permission === PermissionAdmin::MANAGER ||
                                    $userLogin->permission === PermissionAdmin::TAKE_CARE)
                                <td>
                                    <div class="flex items-center gap-2">
                                        @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER)
                                            <a href="{{ route('warehouse.log', ['id' => $warehouse->id]) }}"
                                                class="btn-custom btn-icon btn-success">
                                                <i class="bi bi-card-list"></i> Check log
                                            </a>
                                            <a href="{{ route('warehouse.view_edit', ['id' => $warehouse->id]) }}"
                                                class="btn-custom btn-icon btn-primary">
                                                <i class="bi bi-pen-fill"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('warehouse.view_edit_total', ['id' => $warehouse->id]) }}"
                                                class="btn-custom btn-icon btn-success">
                                                <i class="bi bi-plus"></i> Sửa số lượng
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-admin.table>
            {!! $warehouses->links() !!}
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
