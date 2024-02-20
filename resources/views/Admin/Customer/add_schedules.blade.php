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
            <li>
                <a href="{{ route('bookings.find_list') }}" class="flex items-center">
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
    {{-- End: Navigation --}}
    <form class="form-loading-submit" action="{{ route('customer.add_schedules', ['customer_id' => $customer->id]) }}"
        method="POST">
        @csrf
        @method('POST')
        <input type="hidden" name="user_id" value="{{ $user->id }}" />
        <input type="hidden" name="booking_id" value="{{ $booking->id }}" />
        <input type="hidden" name="time_type" value="{{ $timeType }}" />
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="col-span-1">
                    <h1 class="text-xl font-bold mb-3">Thông tin đặt lịch khám bệnh:</h1>
                    <ul class="space-y-2 text-left">
                        <li class="flex items-center space-x-2">
                            <i class="bi bi-check text-xl text-green-500"></i>
                            <p class="font-medium text-gray-500">Tên bác sĩ: <span
                                    class="text-black">{{ $user->name }}</span></p>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="bi bi-check text-xl text-green-500"></i>
                            <p class="font-medium text-gray-500">Chuyên khoa: <span
                                    class="text-black">{{ $user->specialties->name }}</span></p>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="bi bi-check text-xl text-green-500"></i>
                            <p class="font-medium text-gray-500">Lịch: <span
                                    class="text-black">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span>
                            </p>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="bi bi-check text-xl text-green-500"></i>
                            <p class="font-medium text-gray-500">Giờ đặt: <span
                                    class="text-black">{{ TimeType::getList()[$timeType]['start'] }}
                                </span>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="col-span-2 space-y-2">
                    <div class="form-group">
                        <label for="animal" class=" @error('animal') form-label-error @else form-label @enderror">Chọn thú
                            cưng</label>
                        <select class="form-input" name="animal" id="animal">
                            <option value="">Chọn thú cưng</option>
                            @foreach ($animals as $animal)
                                <option value="{{ $animal->id }}" {{ old('animal') == $animal->id ? 'selected' : '' }}>
                                    {{ $animal->name }} -
                                    {{ TypeAnimal::getList()[$animal->type]['text'] }}
                                    {{ $animal->gender === 1 ? 'Đực' : 'Cái' }} - {{ $animal->species }}
                                </option>
                            @endforeach
                        </select>
                        @error('animal')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description"
                            class=" @error('description') form-label-error @else form-label @enderror">Mô
                            tả</label>
                        <textarea class="form-input" rows="10" name="description" id="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('customer.list') }}" class="btn-custom btn-default"><i class="bi bi-arrow-left"></i>Quay
                    lại</a>
                <button type="submit" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</button>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#logo').change(function() {
                previewImage(this);
            });

            function previewImage(input) {
                const preview = $('#avatar-preview')[0];
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    $('#avatar-preview').show();
                    $("#icon-preview").hide();
                }
            }
        });
    </script>
@endsection
