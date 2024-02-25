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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách loại vật
                        tư</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    <div class="flex items-center my-3">
        <a href="{{ route('type_material.view_add') }}" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm loại
            vật
            tư</a>
    </div>
    {{-- Data list --}}
    @if (!empty($type_materials) and count($type_materials) > 0)
        <x-admin.table>
            <x-slot:header>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Tiêu đề loại
                    </th>
                    <th width="200px">
                        Mô tả
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($type_materials as $type_material)
                    <tr>
                        <td>
                            {{ $type_material->id }}
                        </td>
                        <td>
                            {{ $type_material->name }}
                        </td>
                        <td>
                            <div class="max-h-[200px] overflow-y-auto">
                                {!! $type_material->description !!}
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('type_material.view_edit', ['id' => $type_material->id]) }}"
                                    class="btn-custom btn-icon btn-primary">
                                    <i class="bi bi-pen-fill"></i>
                                </a>
                                <form action="{{ route('type_material.deleted', ['id' => $type_material->id]) }}"
                                    method="POST" class="form-loading-submit">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-custom btn-icon btn-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-admin.table>
        {!! $type_materials->links() !!}
    @else
        <div class="flex items-center gap-2 p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50"
            role="alert">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                <span class="font-medium">Lưu ý!</span> Không tìm thấy dữ liệu nào cả
            </div>
        </div>
    @endif
    {{-- End: Data list --}}
@endsection
