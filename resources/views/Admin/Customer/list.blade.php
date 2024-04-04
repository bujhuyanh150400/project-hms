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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách khách
                        hàng</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    {{-- Search --}}
    <form action="{{ route('customer.list') }}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-4 gap-3 mb-3">

                <div class="form-group">
                    <label class="form-label" for="simple-search">Tìm kiếm</label>
                    <input type="text" class="form-input" name="filter[keyword]" id="keyword"
                        value="{{ old('filter.keyword', $filter['keyword'] ?? '') }}"
                        placeholder="Tìm kiếm theo tên , email , SDT">
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
                <a href="{{ route('customer.view_add') }}" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</a>
            </div>
        </div>
    </form>
    {{-- End:Search --}}

    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($customers) and count($customers) > 0)
            <x-admin.table>
                <x-slot:header>
                    <tr>
                        <th class="text-center align-middle" width='80'>
                            ID
                        </th>
                        <th class="text-center align-middle">
                            Tên khách hàng
                        </th>
                        <th class="text-center align-middle">
                            Email - SDT
                        </th>
                        <th class="text-center align-middle">
                            Địa chỉ
                        </th>
                        <th class="text-center align-middle">
                            Số thú cưng
                        </th>
                        <th class="text-center align-middle">
                            Số lần khám
                        </th>
                        <th class="text-center align-middle">
                            Là thành viên
                        </th>
                        <th class="text-center align-middle">
                            Action
                        </th>
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>
                                {{ $customer->id }}
                            </td>
                            <td class="text-start align-middle font-bold">
                                {{ $customer->name }}
                            </td>
                            <td class="text-start align-middle">
                                {{ $customer->email }} - {{ $customer->phone }}
                            </td>
                            <td class="text-start align-middle">
                                {{ $customer->address_data }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $customer->animal->count() }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $customer->histories == null ? __('chưa khám lần nào') : $customer->histories->count() }}
                            </td>
                            <td class="text-center align-middle">
                                @if (isset($customer->member))
                                    <span
                                        class="bg-green-100 text-green-400 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-green-400">
                                        Member
                                    </span>
                                @else
                                    <span
                                        class="bg-red-100 text-red-400 text-xs font-medium me-2 px-2.5 py-0.5 rounded  border border-red-400">
                                        No
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('customer.find_schedules', ['customer_id' => $customer->id]) }}"
                                        class="btn-custom btn-icon btn-warning" title="Đặt lịch">
                                        <i class="bi bi-journal-plus"></i>
                                    </a>
                                    <a href="{{ route('customer.view', ['customer_id' => $customer->id]) }}"
                                        class="btn-custom btn-icon btn-success" title="Xem chi tiết">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                    <a href="{{ route('customer.view_edit', ['id' => $customer->id]) }}"
                                        class="btn-custom btn-icon btn-primary" title="Chỉnh sửa">
                                        <i class="bi bi-pen-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-admin.table>
            {!! $customers->links() !!}
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
