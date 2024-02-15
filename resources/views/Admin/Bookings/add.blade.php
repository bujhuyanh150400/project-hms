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
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Tìm kiếm giờ khám</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bookings.list', ['user_id' => $user->id]) }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Giờ khám của:
                        {{ $user->name }}</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Thêm giờ khám </span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    <form class="form-loading-submit" action="{{ route('bookings.add', ['user_id' => $user->id]) }}" method="POST">
        @csrf
        @method('POST')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="grid grid-cols-4 gap-4 mb-4">
                <div class="form-group">
                    <label for="date" class=" @error('date') form-label-error @else form-label @enderror"> Chọn ngày
                        khám bệnh</label>
                    <input type="text" name="date" id="date" value="{{ old('date') }}"
                        class="min_today_datepicker @error('date') form-input-error @else form-input @enderror"
                        placeholder="Nhập ngày khám bệnh">
                    @error('name')
                        <span class="form-alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-3">
                    <div class="form-group">
                        <label class=" @error('timeType') form-label-error @else form-label @enderror"> Chọn khung giờ khám
                            bệnh</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach (TimeType::getList() as $times)
                                {{ $times['start'] }}
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('specialties.list') }}" class="btn-custom btn-default"><i
                        class="bi bi-arrow-left"></i>Quay
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
