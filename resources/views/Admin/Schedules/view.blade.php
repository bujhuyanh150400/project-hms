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
    <div class="grid grid-cols-4 gap-4 mb-4">
        <div class="col-span-1 flex flex-col gap-2">
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
                <h1 class="text-xl font-bold mb-3">Thông tin bác sĩ:</h1>
                <ul class="space-y-2 text-left">
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Tên bác sĩ: <span
                                class="text-black">{{ $schedule->user->name }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Chuyên khoa: <span
                                class="text-black">{{ $schedule->user->specialties->name }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Lịch:
                            <span
                                class="text-black">{{ \Carbon\Carbon::parse($schedule->booking->date)->format('d-m-Y') }}</span>
                        </p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Giờ đặt: <span
                                class="text-black">{{ TimeType::getList()[$schedule->timeType]['start'] }}
                            </span>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
                <h1 class="text-xl font-bold mb-3">Thông tin về thú cưng:</h1>
                <ul class="space-y-2 text-left">
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Tên chủ vật nuôi: <span
                                class="text-black">{{ $schedule->customer->name }} -
                                {{ $schedule->customer->gender === 1 ? 'Nam' : 'Nữ' }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Tên vật nuôi: <span
                                class="text-black">{{ $schedule->animal->name }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Loại thú cưng:
                            <span class="text-black">{{ TypeAnimal::getList()[$schedule->animal->type]['text'] }}</span>
                        </p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Giống thú cưng: <span
                                class="text-black">{{ $schedule->animal->species }}</span>
                        </p>
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
        </div>
        <div class="col-span-3 w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
            <form class="form-loading-submit" action="{{ route('schedules.view', ['schedule_id' => $schedule->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="flex flex-col gap-2">
                        
                    </div>
                </div>


            </form>
        </div>
    </div>
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
