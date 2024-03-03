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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Giờ làm các bác sĩ</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    {{-- Search --}}
    <form action="{{ route('bookings.all_bookings') }}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-3 gap-3 mb-3">
                <div class="form-group">
                    <label class="form-label">Tìm theo ngày tạo</label>
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input name="filter[start_date_create]" type="text"
                                   value="{{ old('filter.start_date_create', $filter['start_date_create'] ?? '') }}"
                                   class="form-input-icon datepicker" placeholder="Từ ngày">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input name="filter[end_date_create]"
                                   value="{{ old('filter.end_date_create', $filter['end_date_create'] ?? '') }}"
                                   type="text"
                                   class="form-input-icon datepicker" placeholder="Đến ngày">
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-start items-end gap-3 ">
                <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm kiếm</button>
            </div>
        </div>

        </div>
    </form>
    {{-- End:Search --}}

    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($users) and count($users) > 0)
            <div class="grid grid-cols-5 gap-4">
                @foreach ($users as $user)
                    <div class="flex flex-col items-center gap-2 max-h-[400px] overflow-y-auto">
                        <h1 class="font-medium text-xl">Bác sĩ: {{$user->name}}</h1>
                        @foreach ($user->booking as $booking)
                            @php
                                $listTimeType = explode(',', $booking->timeType);
                                $checkTime = true;
                                if ($booking->date < now()->today()) {
                                    $checkTime = false;
                                }
                            @endphp
                            <div id="{{ $booking->id }}" role="tooltip"
                                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                {{ $checkTime ? 'Lịch của bác sĩ' : 'Lịch làm quá khứ' }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            <div
                                data-tooltip-target="{{ $booking->id }}"
                                class="block p-3 cursor-pointer bg-white border border-gray-200 rounded-lg shadow {{ $checkTime ? 'hover:border-blue-400' : 'border-red-400 bg-red-100 text-red-600' }} hover:shadow-lg duration-150 transition-all">
                                <h5 class="mb-2 text-lg font-bold tracking-tight ">Lịch khám :
                                    {{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</h5>
                                <p class="font-medium text-xs">Lịch khám:</p>
                                <div class="grid grid-cols-5 gap-2 mt-3">
                                    @foreach ($listTimeType as $timeType)
                                        <div
                                            class="inline-flex items-center justify-center w-full text-sm font-medium p-1 bg-white border-2 rounded-lg cursor-pointer  {{ $checkTime ? 'border-blue-400 text-blue-600 ' : 'border-red-400 bg-red-100 text-red-600' }}">
                                            {{ TimeType::getList()[$timeType]['start'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>


            {!! $users->links() !!}
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
