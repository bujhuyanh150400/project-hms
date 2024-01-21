@extends('Admin.Layout.index')

@section('title',$title)

@section('body')
    {{-- Navigation--}}
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 max-w-fit"
         aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{route('admin.dashboard')}}"
                   class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <i class="bi bi-house-door-fill"></i>
                    Trang chủ
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span
                        class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách phòng khám</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation--}}

    {{-- Search--}}
    <form action="{{route('clinic.list')}}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-4 gap-3 mb-3">

                <div class="form-group">
                    <label class="form-label" for="simple-search" >Tìm kiếm</label>
                    <input type="text"
                           class="form-input" name="filter[keyword]" id="keyword" value="{{ old('filter.keyword', $filter['keyword'] ?? '') }}"
                           placeholder="Tìm kiếm theo tên , email">
                </div>
                <div class="form-group">
                    <label class="form-label" for="role" >Cơ sở hoạt động</label>
                    <select id="role" name="filter[active]" class="form-input">
                        <option value="">Chọn</option>
                        <option value="0" {{ old('filter.active', $filter['active'] ?? '') === 0 ? 'selected' : '' }}>Không hoạt động</option>
                        <option value="1" {{ old('filter.active', $filter['active'] ?? '') === 1 ? 'selected' : '' }}>Đang hoạt động</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tìm theo ngày tạo</label>
                    <div date-rangepicker class="flex items-center space-x-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input name="filter[start_date_create]"
                                   type="text"
                                   value="{{old('filter.start_date_create',$filter['start_date_create'] ?? '')}}"
                                   class="form-input-icon" placeholder="Từ ngày">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input name="filter[end_date_create]" value="{{old('filter.end_date_create',$filter['end_date_create'] ?? '')}}" type="text" class="form-input-icon" placeholder="Đến ngày">
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm kiếm</button>
                <a href="{{route('clinic.view_add')}}" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</a>
            </div>
        </div>
    </form>
    {{-- End:Search--}}

    {{-- Data list --}}
    <div class="mt-9">
        @if(!empty($clinics) and count($clinics) > 0)
            <x-admin.table>
                <x-slot:header>
                    <tr>
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
                            Ngày tạo
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach($clinics as $clinic)
                    @endforeach
                </x-slot:body>
            </x-admin.table>
            {!! $clinics->links() !!}
        @else
            <div
                class="flex items-center gap-2 p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50"
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
