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
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">lịch khám cơ sở</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    {{-- Search --}}
    <form action="{{ route('schedules.all_schedules') }}" method="GET" class="form-loading-submit">
        <div class="relative bg-white shadow-md rounded-lg mt-4 border p-4 ">
            <div class="grid grid-cols-3 gap-3 mb-3">
                <div class="form-group">
                    <label class="form-label">Tìm kiếm khách hàng</label>
                    <input type="text" class="form-input" name="filter[customer]" id="keyword"
                           value="{{ old('filter.customer', $filter['customer'] ?? '') }}"
                           placeholder="Tìm kiếm theo tên , email , SDT, ID">
                </div>
                <div class="form-group">
                    <label class="form-label">Tìm theo ngày đặt lịch</label>
                    <div class="grid grid-cols-2 gap-2">
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
    </form>
    {{-- End:Search --}}

    {{-- Data list --}}
    <div class="mt-9">
        @if (!empty($schedules) and count($schedules) > 0)
            <div class="grid grid-cols-3 gap-4">
                @foreach ($schedules as $key_schedules =>$schedule)
                    @php
                        $checkTime = true;
                        if ($schedule->booking->date < now()->today()) {
                            $checkTime = false;
                        }
                    @endphp
                    <div data-popover id="{{ $schedule->id }}" role="tooltip"
                         class="absolute z-50  invisible inline-block w-fit text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0">
                        <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Thông tin lịch khám</h3>
                        </div>
                        <div class="px-3 py-2 ">
                            <ul class="space-y-2 text-left">
                                <li class="flex items-center space-x-2">
                                    <i class="bi bi-check text-xl text-green-500"></i>
                                    <p class="font-medium text-gray-500">Chuyên khoa: <span
                                            class="text-black">{{ $schedule->user->specialties->name }}</span></p>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="bi bi-check text-xl text-green-500"></i>
                                    <p class="font-medium text-gray-500">Tên chủ vật nuôi: <span
                                            class="text-black">{{ $schedule->customer->name }} -
                                {{ $schedule->customer->gender === 1 ? 'Nam' : 'Nữ' }}</span></p>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="bi bi-check text-xl text-green-500"></i>
                                    <p class="font-medium text-gray-500">Thú cưng bao tuổi: <span
                                            class="text-black">{{ $schedule->animal->age }} tuổi</span>
                                    </p>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="bi bi-check text-xl text-green-500"></i>
                                    <p class="font-medium text-gray-500">Ghi chú khi khám: </p>
                                </li>
                                <li class="form-group">
                                    <textarea class="form-input" rows="5" disabled>{{ !empty($schedule->description) ? $schedule->description : 'Không có ghi chú' }} </textarea>
                                </li>
                            </ul>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                    <div
                        @if($loop->iteration % 3 === 1)
                            data-popover-placement="right"
                        @else
                            data-popover-placement="left"
                        @endif
                        data-popover-target="{{ $schedule->id }}"
                        class="block p-3 cursor-pointer bg-white border border-gray-200 rounded-lg shadow hover:border-blue-400 hover:shadow-lg duration-150 transition-all">
                        <div class="flex items-center gap-2">
                            <p
                                class="inline-flex items-center justify-center mb-2 text-sm font-medium px-2 py-1 bg-white border-2 rounded-lg cursor-pointer border-blue-400 text-blue-600  ">
                                Lịch khám :{{ TimeType::getList()[$schedule->timeType]['start'] }} |
                                {{ \Carbon\Carbon::parse($schedule->booking->date)->format('d-m-Y') }}
                            </p>
                            <p class="mb-2 text-sm font-medium  tracking-tight text-gray-600">Khách đặt lúc :
                                {{ \Carbon\Carbon::parse($schedule->created_at)->format('d-m-Y H:i:s') }}
                            </p>
                        </div>
                        <p class="font-bold mb-1">Thông tin đặt lịch khám bệnh:</p>
                        <ul class="space-y-2 text-left">
                            <li class="flex items-center space-x-2">
                                <i class="bi bi-check text-xl text-green-500"></i>
                                <p class="font-medium text-gray-500">Khách hàng:
                                    <span class="text-black">
                                        {{ $schedule->user->name }} -
                                        {{ $schedule->user->gender === 1 ? 'Nam' : 'Nữ' }}
                                    </span>
                                </p>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="bi bi-check text-xl text-green-500"></i>
                                <p class="font-medium text-gray-500">Thú cưng:
                                    <span class="text-black">
                                        {{ $schedule->animal->name }} -
                                        {{ TypeAnimal::getList()[$schedule->animal->type]['text'] }}
                                    </span>
                                </p>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="bi bi-check text-xl text-green-500"></i>
                                <p class="font-medium text-gray-500">Giống:
                                    <span class="text-black">
                                        {{ $schedule->animal->species }}
                                    </span>
                                </p>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="bi bi-check text-xl text-green-500"></i>
                                <p class="font-medium text-gray-500">Trạng thái khám: @if (!$checkTime){{SchedulesStatus::getList()[$schedule->status]['text'] }} @endif</p>
                            </li>
                            @if ($checkTime)
                                <li>
                                    <div class="form-group">
                                        <input type="hidden" class="hidden-status" value="{{$schedule->status}}"/>
                                        <select class="form-input change-status" data-id="{{ $schedule->id }}">
                                            @foreach(SchedulesStatus::getList() as $status)
                                                <option value="{{$status['value']}}"
                                                        @if($schedule->status == $status['value']) selected @endif> {{$status['text']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
            {!! $schedules->links() !!}
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
@section('scripts')
    <script type="module">
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {
            $('.change-status').on('change', function () {
                const id = $(this).data('id');
                const old_status = $(this).closest('.form-group').find('.hidden-status').val()
                if (confirm('Bạn muốn thay đổi trạng thái khám bệnh ?')) {
                    $.ajax({
                        url: '{{route('schedules.change_status')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            id,
                            status: $(this).val()
                        },
                        success: function (response) {
                            notyf.open({
                                type: 'success',
                                message: response.messages
                            });
                        },
                        error: function (xhr, status, error) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                $.each(errors, function (key, value) {
                                    notyf.open({
                                        type: 'error',
                                        message: value[0]
                                    });
                                });
                            } else {
                                notyf.open({
                                    type: 'error',
                                    message: xhr.responseJSON.message
                                });
                            }
                            $(this).val(old_status);
                        }
                    });
                } else {
                    $(this).val(old_status);
                }
            })
        });
    </script>
@endsection
