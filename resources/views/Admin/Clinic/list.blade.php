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
                           placeholder="Tìm kiếm theo tên cơ sở">
                </div>
                <div class="form-group">
                    <label class="form-label" for="role" >Cơ sở hoạt động</label>
                    <select id="role" name="filter[active]" class="form-input">
                        <option value="">Chọn</option>
                        <option value="0" {{ old('filter.active', $filter['active'] ?? '') === 1 ? 'selected' : '' }}>Không hoạt động</option>
                        <option value="1" {{ old('filter.active', $filter['active'] ?? '') === 2 ? 'selected' : '' }}>Đang hoạt động</option>
                    </select>
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
                            Tên cơ sở
                        </th>
                        <th>
                            Logo
                        </th>
                        <th>
                            Địa chỉ
                        </th>
                        <th>
                            Trạng thái
                        </th>
                        <th>
                            Mô tả
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach($clinics as $clinic)
                        <tr>
                            <td>
                                <a class="hover:!text-blue-700 font-medium" href="{{route('clinic.view',['id'=>$clinic->id])}}">{{$clinic->name}}</a>
                            </td>
                            <td>
                                <img
                                    class="w-32 h-32 rounded"
                                    @if(!empty($clinic->logo))
                                        src="{{ route('file.show', ['filepath' => $clinic->logo]) }}"
                                    @else
                                        src="{{asset('assets/images/clinic.png')}}"
                                    @endif
                                    alt="clinic logo"
                                />
                            </td>
                            <td>
                                {{ $clinic->address_data}}
                            </td>
                            <td>
                                {{ $clinic->active === 1 ? "Đang hoạt động" : "Dừng hoạt động" }}
                            </td>
                            <td>
                                <div class="max-h-[200px] overflow-y-auto">
                                    {!! $clinic->description !!}
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{route('clinic.view_edit',['id'=>$clinic->id])}}"
                                       class="btn-custom btn-primary">
                                        <i class="bi bi-pen-fill text-xs"></i>
                                        Sửa
                                    </a>
                                    <form action="{{route('clinic.deleted',['id'=>$clinic->id])}}" method="POST" class="form-loading-submit">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-custom btn-danger">
                                            <i class="bi bi-trash-fill text-xs"></i>
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
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
