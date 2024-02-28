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
            <li>
                <a href="{{ route('warehouse.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách loại vật tư</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Log vật tư:
                        {{ $warehouse->name }}</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($warehouse_logs) and count($warehouse_logs) > 0)
            <x-admin.table>
                <x-slot:header>
                    <tr>
                        <th>
                            Nội dung
                        </th>
                        <th>
                            Người thay đổi
                        </th>
                        <th>
                            Ngày tạo
                        </th>
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach ($warehouse_logs as $warehouse_log)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="max-h-[200px] overflow-y-auto">
                                    {!! $warehouse_log->description !!}
                                </div>
                            </td>
                            <td class="text-start align-middle">
                                {{ $warehouse_log->user->name }} - {{ $warehouse_log->user->clinic->name }}
                            </td>
                            <td class="text-start align-middle">
                                {{ \Carbon\Carbon::parse($warehouse_log->create_at)->format('d-m-Y H:i:s') }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-admin.table>
            {!! $warehouse_logs->links() !!}
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
