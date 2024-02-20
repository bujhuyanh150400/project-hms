@extends('Admin.Layout.index')
@section('title', $title)

@php
    if (isset($bookings)) {
        $secondStep = true;
    } else {
        $secondStep = false;
    }
@endphp
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
            <li>
                <a href="{{ route('customer.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách khách hàng</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Đăng kí lịch khám </span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="grid grid-cols-6 gap-4">
        <ul class="col-span-1 flex-column space-y space-y-4 text-sm font-medium text-gray-500 ">
            <li>
                <a @if ($secondStep === true) href="{{ route('customer.find_schedules', ['customer_id' => $customer->id]) }}" @endif
                    class="inline-flex items-center px-4 py-3 {{ $secondStep === true ? 'bg-gray-50 text-gray-400 border-2' : 'text-white bg-blue-600' }}  rounded-lg  w-full">
                    Tìm ngày khám
                </a>
            </li>
            <li>
                <a
                    class="inline-flex items-center px-4 py-3 {{ $secondStep === true ? 'text-white bg-blue-600' : 'bg-gray-50 border-2 text-gray-400 cursor-not-allowed' }} rounded-lg w-full">
                    Chọn bác sĩ khám bệnh
                </a>
            </li>
        </ul>
        <div class="col-span-5 w-full">
            @if ($secondStep === false)
                <form class="form-loading-submit  p-4 bg-white border border-gray-200 rounded-lg shadow"
                    action="{{ route('customer.find_schedules', ['customer_id' => $customer->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="grid grid-cols-5 gap-2 mb-4">
                        <div class="form-group col-span-2 flex items-center ">
                            <label for="date" class=" @error('date') form-label-error @else form-label @enderror">
                                Chọn ngày khám bệnh</label>
                            <input type="text" name="date" id="date" value="{{ old('date') }}"
                                class="find_date_schedules hidden" placeholder="Nhập ngày khám bệnh">
                            @error('date')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-span-3">
                            <label class=" @error('specialty') form-label-error @else form-label @enderror">
                                Chọn chuyên khoa khám</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($specialties as $key_specialty => $specialty)
                                    <div>
                                        <input type="radio" name="specialty" id="specialty-{{ $key_specialty }}"
                                            @if (old('specialty') === $specialty->id) checked @endif value="{{ $specialty->id }}"
                                            class="hidden peer">
                                        <label for="specialty-{{ $key_specialty }}"
                                            class="inline-flex items-center 
                                        justify-center w-full p-3 
                                        text-blue-400 bg-white border-2 
                                        border-blue-200 rounded-lg cursor-pointer  
                                        peer-checked:border-blue-600 peer-checked:shadow-md duration-150 transition-all 
                                        hover:text-blue-600  peer-checked:text-blue-600 hover:bg-blue-50 ">
                                            <div class="block">
                                                <div class="w-full text-center align-middle text-lg font-semibold">
                                                    {{ $specialty->name }}
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('specialty')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end items-center gap-2">
                        <a href="{{ route('customer.list') }}" class="btn-custom btn-default"><i
                                class="bi bi-arrow-left"></i>Quay
                            lại</a>
                        <button type="submit" class="btn-custom btn-primary"><i class="bi bi-search"></i>Tìm lịch</button>
                    </div>
                </form>
            @else
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($bookings as $booking)
                        @php
                            $listTimeType = explode(',', $booking->timeType);
                            $listTimeTypeSelected = explode(',', $booking->timeTypeSelected);
                        @endphp
                        <div
                            class="block max-w-sm p-3  bg-white border border-gray-200 rounded-lg shadow  hover:border-blue-400 hover:shadow-lg duration-150 transition-all">
                            <p class="mb-2 text-md font-bold tracking-tight ">
                                {{ UserStatus::getList()[$booking->user->user_status]['text_vn'] }}
                                {{ $booking->user->name }}
                            </p>
                            <p class="mb-2 text-xs font-bold tracking-tight ">Chuyên ngành :
                                {{ $booking->user->specialties->name }}</p>
                            <p class="font-medium text-xs">Lịch khám:
                                {{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</p>
                            <div class="grid grid-cols-5 gap-2 mt-3">
                                @foreach ($listTimeType as $timeType)
                                    @php
                                        $emptyBooking = in_array($timeType, $listTimeTypeSelected) ? false : true;
                                    @endphp
                                    <a @if ($emptyBooking === true) href="{{ route('customer.view_add_schedules', [
                                        'customer_id' => $customer->id,
                                        'user_id' => $booking->user->id,
                                        'booking_id' => $booking->id,
                                        'time_type' => $timeType,
                                    ]) }}" @endif
                                        class="inline-flex items-center justify-center w-full text-sm font-medium p-1 bg-white border-2 rounded-lg cursor-pointer {{ $emptyBooking === true ? 'border-blue-400 text-blue-600 hover:bg-blue-400 hover:text-white hover:shadow-lg' : 'border-red-400 text-red-600 bg-red-300' }}  ">
                                        {{ TimeType::getList()[$timeType]['start'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    {{-- End: Navigation --}}

@endsection
@section('scripts')
    <script type="module">
        flatpickr('.find_date_schedules', {
            altInput: true,
            inline: true, // Hiển thị lịch trực tiếp trên trang
            minDate: "today",
            enableTime: false, // Tắt chức năng chọn thời gian
            altFormat: "d-m-Y",
            dateFormat: "Y-m-d",
        });
    </script>
@endsection
