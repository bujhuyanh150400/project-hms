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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Danh sách thú cưng</span>
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
                    <label class="form-label" for="keyword">Tìm kiếm</label>
                    <input type="text" class="form-input" name="filter[keyword]" id="keyword"
                        value="{{ old('filter.keyword', $filter['keyword'] ?? '') }}"
                        placeholder="Tìm kiếm theo tên hoặc id của thú cưng">
                </div>
                <div class="form-group">
                    <label class="form-label" for="keycust">Tìm kiếm theo Khách hàng</label>
                    <input type="text" class="form-input" name="filter[keycust]" id="keycust"
                        value="{{ old('filter.keycust', $filter['keycust'] ?? '') }}"
                        placeholder="Tìm kiếm theo tên , email , SDT của khách hàng ">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm kiếm</button>
                <a href="{{ route('animal.find_cust') }}" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</a>
            </div>
        </div>
    </form>
    {{-- End:Search --}}

    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($animals) and count($animals) > 0)
            <x-admin.table>
                <x-slot:header>
                    <tr>
                        <th class="text-center align-middle" width='80'>
                            ID
                        </th>
                        <th class="text-center align-middle">
                            Ảnh
                        </th>
                        <th class="text-center align-middle">
                            Tên thú cưng
                        </th>
                        <th class="text-center align-middle">
                            Tuổi
                        </th>
                        <th class="text-center align-middle">
                            Loại thú cưng
                        </th>
                        <th class="text-center align-middle">
                            Giống thú cưng
                        </th>
                        <th class="text-center align-middle">
                            Thuộc khách hàng
                        </th>
                        <th class="text-center align-middle">
                            Action
                        </th>
                    </tr>
                </x-slot:header>
                <x-slot:body>
                    @foreach ($animals as $animal)
                        <tr>
                            <td class="text-start align-middle">
                                {{ $animal->id }}
                            </td>
                            <td class="text-start align-middle">
                                <div class="flex items-center justify-center">
                                    <img class="w-10 h-10 rounded-full ring-1 shadow-lg ring-gray-300"
                                        @if (!empty($animal->avatar)) src="{{ route('file.show', ['filepath' => $animal->avatar]) }}"
                                    @else
                                        src="{{ asset('assets/images/animal-demo.png') }}" @endif
                                        alt="avatar logo" />
                                </div>
                            </td>
                            <td class="text-start align-middle font-bold">
                                {{ $animal->name }}
                            </td>
                            <td class="text-start align-middle">
                                {{ $animal->age }}
                            </td>
                            <td class="text-start align-middle">
                                @isset(TypeAnimal::getList()[$animal->type])
                                    {{ TypeAnimal::getList()[$animal->type]['text'] }}
                                @endisset
                            </td>
                            <td class="text-start align-middle">
                                {{ $animal->species }}
                            </td>
                            <td class="text-start align-middle ">
                                <div class="flex flex-col gap-1">
                                    <span class="font-bold">
                                        {{ $animal->customer->name }}
                                    </span>
                                    <span class="text-sm font-italic">ID: {{ $animal->customer->id }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('animal.view', ['id' => $animal->id]) }}"
                                        class="btn-custom btn-icon btn-success">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                    <a href="{{ route('animal.view_edit', ['id' => $animal->id]) }}"
                                        class="btn-custom btn-icon btn-primary">
                                        <i class="bi bi-pen-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-admin.table>
            {!! $animals->links() !!}
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
