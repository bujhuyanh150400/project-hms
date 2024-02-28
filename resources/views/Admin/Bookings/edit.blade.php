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
            @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER)
                <li>
                    <a href="{{ route('bookings.find_list') }}" class="flex items-center">
                        <i class="bi bi-chevron-right"></i>
                        <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Tìm kiếm giờ khám</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('bookings.list', ['user_id' => $booking->user->id]) }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Giờ khám của:
                        {{ $booking->user->name }}</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Sửa giờ khám </span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    <form class="form-loading-submit" action="{{ route('bookings.edit', ['id' => $booking->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
                <div class="form-group col-span-2 flex items-center ">
                    <label for="date" class=" @error('date') form-label-error @else form-label @enderror"> Chọn ngày
                        khám bệnh</label>
                    <input type="text" name="date" id="date" value="{{ old('date', $booking->date) }}"
                        class="min_today_datepicker_inline hidden" placeholder="Nhập ngày khám bệnh">
                    @error('date')
                        <span class="form-alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-3 col-start-3">
                    <div class="form-group">
                        <label class=" @error('timeType') form-label-error @else form-label @enderror"> Chọn khung giờ khám
                            bệnh</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach (TimeType::getList() as $key_time => $time)
                                <div>
                                    <input type="checkbox" name="timeType[]" id="timeType-{{ $key_time }}"
                                        @if (is_array(old('timeType', explode(',', $booking->timeType))) &&
                                                in_array($time['value'], old('timeType', explode(',', $booking->timeType)))) checked @endif value="{{ $time['value'] }}"
                                        value="{{ $time['value'] }}" class="hidden peer">
                                    <label for="timeType-{{ $key_time }}"
                                        class="inline-flex items-center 
                                        justify-center w-full p-3 
                                        text-blue-400 bg-white border-2 
                                        border-blue-200 rounded-lg cursor-pointer  
                                        peer-checked:border-blue-600 peer-checked:shadow-md duration-150 transition-all 
                                        hover:text-blue-600  peer-checked:text-blue-600 hover:bg-blue-50 ">
                                        <div class="block">
                                            <div class="w-full text-center align-middle text-lg font-semibold">
                                                {{ $time['start'] }} -
                                                {{ $time['end'] }}</div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('timeType')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('bookings.list', ['user_id' => $booking->user->id]) }}" class="btn-custom btn-default"><i
                        class="bi bi-arrow-left"></i>Quay
                    lại</a>
                <button type="submit" class="btn-custom btn-success"><i class="bi bi-pencil-square"></i>Sửa</button>
            </div>
        </div>
    </form>
@endsection
